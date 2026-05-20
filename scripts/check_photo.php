<?php
$photoName = 'A. Dede Ali S.pd.jpeg';
$base = pathinfo($photoName, PATHINFO_FILENAME);
$ext = pathinfo($photoName, PATHINFO_EXTENSION);
$candidates = [];
$candidates[] = $photoName;
$candidates[] = preg_replace('/[.,]+/', '', $photoName);
$candidates[] = strtolower(preg_replace('/[^0-9a-zA-Z]+/', '-', $base)) . '.' . $ext;
$candidates[] = strtolower(preg_replace('/[^0-9a-zA-Z]+/', '_', $base)) . '.' . $ext;

foreach ($candidates as $cand) {
    $path = __DIR__ . '/../public/images/' . $cand;
    echo $cand . ' -> ' . (file_exists($path) ? 'exists' : 'missing') . PHP_EOL;
}
