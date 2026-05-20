<?php

$imagesDir = __DIR__ . '/../public/images/';
$teachers = [
    'A. Dede Ali, S.Pd',
    'Wiwi Suherti, S.Pd',
    'Ade Royani, S.Pd',
    'Siti Rokayah',
    'Siti Aminah',
    'Warnengsih',
    'Rinda Maryani, S.Pd',
    'Mochamad Fazhri Syamsi'
];

$missingPhotos = [];

foreach ($teachers as $teacher) {
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $teacher));
    $filename = $slug . '.jpeg';

    if (!file_exists($imagesDir . $filename)) {
        $missingPhotos[] = $filename;
    }
}

if (empty($missingPhotos)) {
    echo "All photos are present.\n";
} else {
    echo "Missing photos:\n";
    foreach ($missingPhotos as $missing) {
        echo "- $missing\n";
    }
}
