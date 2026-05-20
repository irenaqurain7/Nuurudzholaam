<?php
require __DIR__ . '/../vendor/autoload.php';
use Illuminate\Support\Str;

$defaultTeachers = [
    (object)['name' => 'A. Dede Ali, S.Pd', 'role' => 'Kepala Yayasan Raudhah Syarifah', 'photo' => 'a-dede-ali-s-pd.jpeg'],
    (object)['name' => 'Wiwi Suherti, S.Pd', 'role' => 'Kepala Sekolah Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Ade Royani, S.Pd', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Siti Rokayah', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Siti Aminah', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Warnengsih', 'role' => 'Tenaga Pendidik SD, SMP, SMK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Rinda Maryani, S.Pd', 'role' => 'Tenaga Pendidik TK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Mochamad Fazhri Syamsi', 'role' => 'Tenaga Pendidik SMP, SMK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Dinda Aulia Putri', 'role' => 'Tenaga Pendidik SMP, SMK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Kurnia Amelia', 'role' => 'Tenaga Pendidik SMP, SMK Nuurudzholaam', 'photo' => null],
    (object)['name' => 'Jihan', 'role' => 'Tenaga Pendidik TK Nuurudzholaam', 'photo' => null],
];
$extensions = ['jpg', 'jpeg', 'png', 'webp'];
$dir = __DIR__ . '/../public/images/';
foreach ($defaultTeachers as $idx => $t) {
    if (!empty($t->photo)) {
        $path = $dir . $t->photo;
        if (!file_exists($path)) {
            $base = pathinfo($t->photo, PATHINFO_FILENAME);
            foreach ($extensions as $ext) {
                $try = $dir . $base . '.' . $ext;
                if (file_exists($try)) {
                    $defaultTeachers[$idx]->photo = basename($try);
                    break;
                }
            }
            $variants = [Str::slug($base, '-'), Str::slug($base, '_')];
            foreach ($variants as $v) {
                foreach ($extensions as $ext) {
                    $try = $dir . $v . '.' . $ext;
                    if (file_exists($try)) {
                        $defaultTeachers[$idx]->photo = basename($try);
                        break 2;
                    }
                }
            }
        }
        echo "$t->name => " . ($defaultTeachers[$idx]->photo ?: 'null') . "\n";
        continue;
    }
    $name = $t->name;
    $normalizedName = str_replace('.', ' ', $name);
    $candidates = [];
    $candidates[] = $name;
    $candidates[] = preg_replace('/[.,]/', '', $name);
    $candidates[] = Str::slug($name, '-');
    $candidates[] = Str::slug($name, '_');
    $candidates[] = Str::slug($normalizedName, '-');
    $candidates[] = Str::slug($normalizedName, '_');
    $found = false;
    echo "Candidates for $name:\n";
    foreach ($candidates as $cand) {
        foreach ($extensions as $ext) {
            $file = $dir . $cand . '.' . $ext;
            $exists = file_exists($file);
            echo "  $cand.$ext => " . ($exists ? 'exists' : 'missing') . "\n";
            if ($exists) {
                $defaultTeachers[$idx]->photo = basename($file);
                $found = true;
                break 2;
            }
        }
    }
    echo "$name => " . ($defaultTeachers[$idx]->photo ?: 'null') . "\n\n";
}
