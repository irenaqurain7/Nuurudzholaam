<?php
$mode = $argv[1] ?? 'dry-run';
$files = glob(__DIR__ . '/../public/images/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
foreach ($files as $f) {
    $base = pathinfo($f, PATHINFO_FILENAME);
    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
    $new = preg_replace('/[^0-9a-zA-Z]+/', '-', $base);
    $new = strtolower($new) . '.' . $ext;
    $dest = dirname($f) . DIRECTORY_SEPARATOR . $new;
    if ($mode === 'dry-run') {
        echo "DRY-RUN: " . basename($f) . " => " . basename($dest) . "\n";
    } else {
        if (basename($f) === basename($dest)) {
            echo "SKIP: " . basename($f) . " (already correct)\n";
            continue;
        }
        if (file_exists($dest)) {
            echo "CONFLICT: " . basename($dest) . " already exists, skipping rename of " . basename($f) . "\n";
            continue;
        }
        if (rename($f, $dest)) {
            echo "RENAMED: " . basename($f) . " => " . basename($dest) . "\n";
        } else {
            echo "FAILED: " . basename($f) . "\n";
        }
    }
}
