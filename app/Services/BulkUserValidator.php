<?php

namespace App\Services;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Validation\Rule;

class BulkUserValidator
{
    private array $requiredColumns = [
        'Nama Lengkap',
        'Email',
        'Password',
        'Role (siswa/guru)',
        'NISN/NIP',
        'Jenjang (Siswa) / Spesialisasi (Guru)',
        'Kelas / -',
        'No Telepon',
        'Alamat',
    ];

    private array $errors = [];
    private array $validatedData = [];
    private array $warnings = [];

    /**
     * Validasi file dan struktur
     */
    public function validateFileStructure($file): bool
    {
        $handle = fopen($file->getRealPath(), 'r');
        if (!$handle) {
            $this->errors[] = 'Tidak dapat membuka file.';
            return false;
        }

        $header = fgetcsv($handle, 1000, ",");
        fclose($handle);

        if (!$header) {
            $this->errors[] = 'File kosong atau format tidak valid.';
            return false;
        }

        // Trim header
        $header = array_map('trim', $header);

        // Check required columns
        $missingColumns = array_diff($this->requiredColumns, $header);
        if (!empty($missingColumns)) {
            $this->errors[] = 'Kolom yang kurang: ' . implode(', ', $missingColumns);
            return false;
        }

        return true;
    }

    /**
     * Parse dan validasi data dari file
     */
    public function parseAndValidate($file): array
    {
        if (!$this->validateFileStructure($file)) {
            return [
                'success' => false,
                'errors' => $this->errors,
                'data' => [],
                'warnings' => [],
            ];
        }

        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle, 1000, ",");
        $header = array_map('trim', $header);

        $rowNumber = 1;
        $validRows = [];
        $invalidRows = [];

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $rowNumber++;

            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $rowData = array_combine($header, array_map('trim', $row));
            $validation = $this->validateRow($rowData, $rowNumber);

            if ($validation['valid']) {
                $validRows[] = $validation['data'];
            } else {
                $invalidRows[] = $validation;
            }
        }

        fclose($handle);

        $this->validatedData = $validRows;

        return [
            'success' => count($invalidRows) === 0,
            'errors' => $this->errors,
            'valid_rows' => $validRows,
            'invalid_rows' => $invalidRows,
            'warnings' => $this->warnings,
            'summary' => [
                'total' => count($validRows) + count($invalidRows),
                'valid' => count($validRows),
                'invalid' => count($invalidRows),
            ]
        ];
    }

    /**
     * Validasi satu baris data
     */
    private function validateRow($row, $rowNumber): array
    {
        $errors = [];

        // Extract data
        $name = $row['Nama Lengkap'] ?? '';
        $email = $row['Email'] ?? '';
        $password = $row['Password'] ?? '';
        $role = strtolower($row['Role (siswa/guru)'] ?? '');
        $nisn_nip = $row['NISN/NIP'] ?? '';
        $jenjang_spec = $row['Jenjang (Siswa) / Spesialisasi (Guru)'] ?? '';
        $class_kelas = $row['Kelas / -'] ?? '';
        $phone = $row['No Telepon'] ?? '';
        $address = $row['Alamat'] ?? '';

        // Validasi required fields
        if (empty($name)) {
            $errors[] = 'Nama lengkap tidak boleh kosong';
        }

        if (empty($email)) {
            $errors[] = 'Email tidak boleh kosong';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid: ' . $email;
        }

        if (empty($password)) {
            $errors[] = 'Password tidak boleh kosong';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password minimal 6 karakter';
        }

        if (empty($role)) {
            $errors[] = 'Role tidak boleh kosong (siswa/guru)';
        } elseif (!in_array($role, ['siswa', 'guru'])) {
            $errors[] = 'Role hanya boleh: siswa atau guru, diterima: ' . $role;
        }

        // Validasi NISN/NIP
        if (empty($nisn_nip) || $nisn_nip === '-') {
            $errors[] = 'NISN/NIP tidak boleh kosong';
        }

        // Validasi Jenjang/Spesialisasi
        if (empty($jenjang_spec) || $jenjang_spec === '-') {
            $errors[] = 'Jenjang/Spesialisasi tidak boleh kosong';
        }

        // Role-specific validations
        if ($role === 'siswa') {
            if (!in_array($jenjang_spec, ['TK', 'SD', 'SMP', 'SMA', 'SMK'])) {
                $errors[] = 'Jenjang hanya boleh: TK, SD, SMP, SMA, SMK. Diterima: ' . $jenjang_spec;
            }

            if (empty($class_kelas) || $class_kelas === '-') {
                $errors[] = 'Kelas tidak boleh kosong untuk siswa';
            }

            // Validasi NISN format (13 digit)
            if (!preg_match('/^\d{13}$/', str_replace([' ', '-'], '', $nisn_nip))) {
                $errors[] = 'NISN harus 13 digit angka, diterima: ' . $nisn_nip;
            }

            // Check NISN duplicate
            if (Student::where('nisn', $nisn_nip)->exists()) {
                $errors[] = 'NISN sudah terdaftar: ' . $nisn_nip;
            }
        } elseif ($role === 'guru') {
            // Validasi NIP format (18 digit)
            if (!preg_match('/^\d{18}$/', str_replace([' ', '-'], '', $nisn_nip))) {
                $errors[] = 'NIP harus 18 digit angka, diterima: ' . $nisn_nip;
            }

            // Check NIP duplicate
            if (Teacher::where('nip', $nisn_nip)->exists()) {
                $errors[] = 'NIP sudah terdaftar: ' . $nisn_nip;
            }
        }

        // Check email duplicate
        if (User::where('email', $email)->exists()) {
            $errors[] = 'Email sudah terdaftar: ' . $email;
        }

        // Validasi format phone (opsional tapi jika ada harus valid)
        // Accept format: 08xxx, +6281xxx, 6281xxx, 81xxx, dst (min 10 digit)
        if (!empty($phone)) {
            $phoneClean = str_replace([' ', '-', '+'], '', $phone);
            // Pattern yang fleksibel untuk berbagai format nomor Indonesia
            // Minimal 10 digit, maksimal 13 digit (untuk format +62)
            if (!preg_match('/^(?:62)?[0-9]{10,13}$/', $phoneClean)) {
                $this->warnings[] = "Baris $rowNumber: Format nomor telepon mungkin tidak sesuai standar, tapi akan tetap disimpan: $phone";
            }
        }

        if (empty($errors)) {
            return [
                'valid' => true,
                'row_number' => $rowNumber,
                'data' => [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'role' => $role,
                    'nisn_nip' => $nisn_nip,
                    'jenjang_spesialisasi' => $jenjang_spec,
                    'kelas' => $class_kelas !== '-' ? $class_kelas : null,
                    'phone' => $phone ?: null,
                    'address' => $address ?: null,
                ]
            ];
        }

        return [
            'valid' => false,
            'row_number' => $rowNumber,
            'name' => $name ?: '(tidak diisi)',
            'email' => $email ?: '(tidak diisi)',
            'errors' => $errors,
        ];
    }

    /**
     * Get validated data yang siap untuk disimpan
     */
    public function getValidatedData(): array
    {
        return $this->validatedData;
    }

    /**
     * Get all errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get all warnings
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }
}
