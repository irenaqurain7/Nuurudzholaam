<?php
$dir = __DIR__ . '/../public/images';
$files = array_values(array_filter(scandir($dir), fn($f) => is_file($dir . '/' . $f)));
foreach ($files as $file) {
    echo $file . PHP_EOL;
}
