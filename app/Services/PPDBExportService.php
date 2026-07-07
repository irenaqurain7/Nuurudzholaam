<?php

namespace App\Services;

use App\Models\PPDBRegistration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PPDBExportService
{
    public function filteredQuery(Request $request): Builder
    {
        $query = PPDBRegistration::query();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $like = '%' . mb_strtolower($search) . '%';

            $query->where(function (Builder $builder) use ($like) {
                $builder->whereRaw('LOWER(nama_lengkap) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(email) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(no_telepon) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(asal_sekolah) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(COALESCE(nisn, "")) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(COALESCE(program, "")) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(COALESCE(jurusan, "")) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(jenjang) LIKE ?', [$like]);
            });
        }

        if ($request->filled('status')) {
            $status = $this->normalizeStatus((string) $request->input('status'));

            if ($status !== null) {
                $query->where('status', $status);
            }
        }

        if ($request->filled('jenjang')) {
            $jenjang = strtolower((string) $request->input('jenjang'));
            if (in_array($jenjang, ['tk', 'sd', 'smp', 'smk'], true)) {
                $query->whereRaw('LOWER(jenjang) = ?', [$jenjang]);
            }
        }

        return $query;
    }

    public function mapExportRows(Collection $registrations): Collection
    {
        return $registrations->values()->map(function ($registration, int $index) {
            $registeredAt = $registration->tgl_daftar ?? $registration->created_at;

            return [
                'no' => $index + 1,
                'nama_lengkap' => $registration->nama_lengkap ?? '-',
                'jenjang' => strtoupper((string) ($registration->jenjang ?? '-')),
                'email' => $registration->email ?? '-',
                'nomor_hp' => $registration->no_telepon ?? '-',
                'asal_sekolah' => $registration->asal_sekolah ?? '-',
                'program_jurusan' => $this->resolveProgramJurusan($registration),
                'status' => $this->resolveStatusLabel($registration->status ?? null),
                'tanggal_daftar' => $registeredAt ? $registeredAt->format('d-m-Y H:i') : '-',
            ];
        });
    }

    public function resolveStatusLabel(?string $status): string
    {
        return match (strtolower((string) $status)) {
            'pending' => 'Pending',
            'approved', 'diterima' => 'Approved',
            'rejected', 'ditolak' => 'Rejected',
            default => ucfirst((string) $status),
        };
    }

    public function resolveProgramJurusan(object $registration): string
    {
        if (!empty($registration->jenjang) && strtolower((string) $registration->jenjang) === 'smk' && !empty($registration->jurusan)) {
            return (string) $registration->jurusan;
        }

        if (!empty($registration->jenjang) && strtolower((string) $registration->jenjang) === 'sma' && !empty($registration->program)) {
            return ucfirst((string) $registration->program);
        }

        return '-';
    }

    public function normalizeStatus(string $status): ?string
    {
        return match (strtolower(trim($status))) {
            'pending', 'diterima', 'ditolak' => strtolower(trim($status)),
            'approved' => 'diterima',
            'rejected' => 'ditolak',
            default => null,
        };
    }
}
