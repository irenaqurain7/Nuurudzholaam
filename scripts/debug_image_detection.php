<?php
$names = ['Wiwi Suherti, S.Pd', 'Ade Royani, S.Pd', 'Rinda Maryani, S.Pd'];
foreach ($names as $name) {
    $base = $name;
    $candidates = [];
    $candidates[] = $name;
    $candidates[] = preg_replace('/[.,]+/', '', $name);
    $filename = pathinfo($name, PATHINFO_FILENAME);
    $ext = pathinfo($name, PATHINFO_EXTENSION) ?: 'jpeg';
    $candidates[] = strtolower(preg_replace('/[^0-9a-zA-Z]+/', '-', $filename)) . '.' . strtolower($ext);
    $candidates[] = strtolower(preg_replace('/[^0-9a-zA-Z]+/', '_', $filename)) . '.' . strtolower($ext);
    echo "Name: $name\n";
    foreach ($candidates as $cand) {
        $path = __DIR__ . '/../public/images/' . $cand;
        echo "  $cand -> " . (file_exists($path) ? 'exists' : 'missing') . "\n";
    }
    echo "\n";
}
