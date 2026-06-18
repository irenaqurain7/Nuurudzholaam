<?php
// Simple .docx -> schedule extractor
// Usage: php scripts/parse_docx_schedule.php [path/to/file.docx]

$path = $argv[1] ?? __DIR__ . '/../storage/imports/jadwal.docx';
$outJson = __DIR__ . '/../storage/app/jadwal_parsed.json';

if (!file_exists($path)) {
    fwrite(STDERR, "File not found: $path\n");
    exit(2);
}

$zip = new ZipArchive();
if ($zip->open($path) !== true) {
    fwrite(STDERR, "Failed to open docx file.\n");
    exit(3);
}

$xml = $zip->getFromName('word/document.xml');
$zip->close();

if ($xml === false) {
    fwrite(STDERR, "document.xml not found inside docx.\n");
    exit(4);
}

// Normalize paragraph breaks
$xml = str_replace(['</w:p>', '</w:tbl>'], "\n", $xml);

// Remove tags, keep text
$text = preg_replace('/<[^>]+>/', '', $xml);

// Normalize whitespace and split into lines
$lines = preg_split('/\r?\n/', $text);
$lines = array_map('trim', $lines);
$lines = array_filter($lines, function ($l) { return $l !== ''; });
$lines = array_values($lines);

// Heuristic parse: look for day names (Indonesian) to group schedule items
$days = ['Senin','Selasa','Rabu','Kamis','Jumat',"Jum'at",
         'Sabtu','Minggu'];

$result = [];
$currentDay = null;

foreach ($lines as $line) {
    // If line looks like a day header
    foreach ($days as $d) {
        if (stripos($line, $d) !== false && strlen($line) <= 20) {
            $currentDay = $d;
            if (!isset($result[$currentDay])) $result[$currentDay] = [];
            continue 2;
        }
    }

    // Try to extract time range like 07:00-08:30 or 07.00 - 08.30 or 07:00 – 08:30
    if (preg_match('/(\d{1,2}[:\.\-]\d{2})\s*[\-–—]\s*(\d{1,2}[:\.\-]\d{2})/', $line, $m)) {
        $start = str_replace('.', ':', $m[1]);
        $end = str_replace('.', ':', $m[2]);
        // Subject is rest of line without the time
        $subject = trim(preg_replace('/'.preg_quote($m[0], '/').'/', '', $line));
        $entry = ['subject' => $subject ?: '-', 'start_time' => $start, 'end_time' => $end, 'room' => ''];
        if ($currentDay === null) $currentDay = 'Umum';
        $result[$currentDay][] = $entry;
        continue;
    }

    // If line contains time like 07:00 or 07.00 and a subject
    if (preg_match('/(\d{1,2}[:\.]\d{2})/', $line, $m)) {
        $time = str_replace('.', ':', $m[1]);
        // Try to split by comma or tab
        $parts = preg_split('/\s*[,\t]\s*/', $line);
        $subject = count($parts) > 1 ? $parts[0] : preg_replace('/'.preg_quote($m[0], '/').'/', '', $line);
        $entry = ['subject' => trim($subject), 'start_time' => $time, 'end_time' => '', 'room' => ''];
        if ($currentDay === null) $currentDay = 'Umum';
        $result[$currentDay][] = $entry;
        continue;
    }

    // If line contains ' - ' or ':' separators and looks like 'Pelajaran — Ruang'
    if (preg_match('/[A-Za-z0-9\s\'\.\,\-]+/', $line)) {
        // treat as subject-only line
        $entry = ['subject' => $line, 'start_time' => '', 'end_time' => '', 'room' => ''];
        if ($currentDay === null) $currentDay = 'Umum';
        $result[$currentDay][] = $entry;
        continue;
    }
}

// Save JSON
file_put_contents($outJson, json_encode(array_values(array_map(function($k,$v){ return ['day'=>$k,'items'=>$v]; }, array_keys($result), $result)), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));

fwrite(STDOUT, "Parsed schedule saved to: $outJson\n");
fwrite(STDOUT, "Detected groups: " . count($result) . "\n");

// Print summary
foreach ($result as $day => $items) {
    fwrite(STDOUT, "\n$day:\n");
    foreach ($items as $it) {
        fwrite(STDOUT, " - " . ($it['start_time'] ?? '') . ($it['end_time'] ? "-".$it['end_time'] : '') . " " . ($it['subject'] ?? '') . "\n");
    }
}

exit(0);
