<?php

namespace App\Services;

class ScheduleImportService
{
    /**
     * Validate conflicts among items.
     * Each item should have: class, subject, day, start_time, end_time, teacher, room
     * Returns array of items with added 'status' => 'valid'|'conflict' and 'reasons' => []
     */
    public function validateConflicts(array $items): array
    {
        $result = [];

        // normalize times and indexes
        foreach ($items as $i => $it) {
            $result[$i] = array_merge($it, ['status' => 'valid', 'reasons' => []]);
        }

        // check teacher conflicts
        foreach ($result as $i => $a) {
            foreach ($result as $j => $b) {
                if ($i === $j) continue;
                if (empty($a['teacher']) || empty($b['teacher'])) continue;
                if ($a['teacher'] === $b['teacher'] && ($a['day'] ?? '') === ($b['day'] ?? '')) {
                    if ($this->timesOverlap($a['start_time'] ?? '', $a['end_time'] ?? '', $b['start_time'] ?? '', $b['end_time'] ?? '')) {
                        $result[$i]['status'] = 'conflict';
                        $result[$i]['reasons'][] = 'Guru bentrok dengan baris '.($j+1);
                    }
                }
            }
        }

        // check class conflicts
        foreach ($result as $i => $a) {
            foreach ($result as $j => $b) {
                if ($i === $j) continue;
                if (empty($a['class']) || empty($b['class'])) continue;
                if ($a['class'] === $b['class'] && ($a['day'] ?? '') === ($b['day'] ?? '')) {
                    if ($this->timesOverlap($a['start_time'] ?? '', $a['end_time'] ?? '', $b['start_time'] ?? '', $b['end_time'] ?? '')) {
                        $result[$i]['status'] = 'conflict';
                        $result[$i]['reasons'][] = 'Kelas bentrok dengan baris '.($j+1);
                    }
                }
            }
        }

        return array_values($result);
    }

    protected function timesOverlap($s1, $e1, $s2, $e2): bool
    {
        if (empty($s1) || empty($e1) || empty($s2) || empty($e2)) return false;
        $t1 = strtotime($s1);
        $t2 = strtotime($e1);
        $u1 = strtotime($s2);
        $u2 = strtotime($e2);
        if ($t1 === false || $t2 === false || $u1 === false || $u2 === false) return false;
        return max($t1, $u1) < min($t2, $u2);
    }
}
