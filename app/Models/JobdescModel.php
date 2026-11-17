<?php namespace App\Models;

use CodeIgniter\Model;

class JobdescModel extends Model
{
    protected $table = 'jobdesc_kpi';
    protected $primaryKey = 'jk_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'jk_divisi',
        'jk_nama_karyawan',
        'jk_indikator_1', 'jk_indikator_2', 'jk_indikator_3', 'jk_indikator_4',
        'jk_indikator_5', 'jk_indikator_6', 'jk_indikator_7', 'jk_indikator_8',
        'jk_indikator_9', 'jk_indikator_10', 'jk_indikator_11', 'jk_indikator_12',
        'jk_bobot_1', 'jk_bobot_2', 'jk_bobot_3', 'jk_bobot_4',
        'jk_bobot_5', 'jk_bobot_6', 'jk_bobot_7', 'jk_bobot_8',
        'jk_bobot_9', 'jk_bobot_10', 'jk_bobot_11', 'jk_bobot_12',
        'jk_nilai_1', 'jk_nilai_2', 'jk_nilai_3', 'jk_nilai_4',
        'jk_nilai_5', 'jk_nilai_6', 'jk_nilai_7', 'jk_nilai_8',
        'jk_nilai_9', 'jk_nilai_10', 'jk_nilai_11', 'jk_nilai_12',
        'jk_total_kpi',
        'jk_status',
        'jk_created_by',
        'jk_created_date',
        'jk_modified_date',
    ];

    public function getall_kpi_lengkap()
    {
        $rows = $this->db->table($this->table)
            ->select('*')
            ->orderBy('jk_id', 'DESC')
            ->get()
            ->getResultArray();

        return array_values(array_filter($rows, function ($row) {
            return $this->isLengkap($row);
        }));
    }

    public function getall_kpi_pending()
    {
        $rows = $this->db->table($this->table)
            ->select('*')
            ->orderBy('jk_id', 'DESC')
            ->get()
            ->getResultArray();

        return array_values(array_filter($rows, function ($row) {
            return !$this->isLengkap($row);
        }));
    }

    public function isLengkap($row)
    {
        $terisi = 0;

        for ($i = 1; $i <= 12; $i++) {
            if ($row["jk_indikator_{$i}"] === null || $row["jk_indikator_{$i}"] === '') {
                continue;
            }

            $terisi++;

            if ($row["jk_nilai_{$i}"] === null) {
                return false;
            }
        }

        return $terisi > 0;
    }

    public function hitungJumlahTerisi($row)
    {
        $count = 0;

        for ($i = 1; $i <= 12; $i++) {
            if ($row["jk_indikator_{$i}"] !== null && $row["jk_indikator_{$i}"] !== '') {
                $count++;
            }
        }

        return $count;
    }

    public function get_kpi_detail($jk_id)
    {
        return $this->db->table($this->table)
            ->select('*')
            ->where('jk_id', $jk_id)
            ->get()
            ->getRowArray();
    }

    public function hitungKonversi($nilai, $bobot)
    {
        return (float) $nilai * (float) $bobot;
    }

    public function hitungStatus($total)
    {
        if ($total >= 90) {
            return 1;
        } elseif ($total >= 70 || $total <= 80) {
            return 2;
        } elseif ($total >= 60 || $total <= 70) {
            return 3;
        }

        return 4;
    }

    public function statusBadgeClass($status)
    {
        switch ($status) {
            case 1:
                return 'Sangat Baik';
            case 2:
                return 'Baik';
            case 3:
                return 'Cukup';
            case 4:
                return 'Kurang';
        }
    }

    public function insert_indikator($data)
    {
        $this->insert($data);
        return $this->db->insertID();
    }

    public function insert_nilai($jk_id, $nilai)
    {
        $kpi = $this->get_kpi_detail($jk_id);

        if (!$kpi) {
            return false;
        }

        $updateData = [];
        $total = 0;
        $terisi = 0;

        for ($i = 1; $i <= 12; $i++) {
            $filled = $kpi["jk_indikator_{$i}"] !== null && $kpi["jk_indikator_{$i}"] !== '';

            if ($filled) {
                $terisi++;
                $updateData["jk_nilai_{$i}"] = $nilai["jk_nilai_{$i}"];
                $total += $this->hitungKonversi($nilai["jk_nilai_{$i}"], $kpi["jk_bobot_{$i}"]);
            } else {
                $updateData["jk_nilai_{$i}"] = null;
            }
        }

        if ($terisi === 0) {
            return false;
        }

        $updateData['jk_total_kpi'] = round($total, 2);
        $updateData['jk_status'] = $this->hitungStatus($total);
        $updateData['jk_modified_date'] = date('Y-m-d H:i:s');

        return $this->update($jk_id, $updateData);
    }

    public function update_indikator($jk_id, $data)
    {
        $kpi = $this->get_kpi_detail($jk_id);

        if (!$kpi) {
            return false;
        }

        $update = $data;
        $update['jk_modified_date'] = date('Y-m-d H:i:s');

        $total = 0;
        $lengkap = true;
        $terisi = 0;

        for ($i = 1; $i <= 12; $i++) {
            $filled = isset($update["jk_indikator_{$i}"])
                && $update["jk_indikator_{$i}"] !== null
                && $update["jk_indikator_{$i}"] !== '';

            if (!$filled) {
                $update["jk_indikator_{$i}"] = null;
                $update["jk_bobot_{$i}"] = null;

                if (isset($update["jk_nilai_{$i}"])) {
                    $update["jk_nilai_{$i}"] = null;
                }

                continue;
            }

            $terisi++;

            $nilai = isset($update["jk_nilai_{$i}"]) ? $update["jk_nilai_{$i}"] : $kpi["jk_nilai_{$i}"];

            if ($nilai === null) {
                $lengkap = false;
                continue;
            }

            $total += $this->hitungKonversi($nilai, $update["jk_bobot_{$i}"]);
        }

        if ($terisi === 0) {
            $lengkap = false;
        }

        if ($lengkap) {
            $update['jk_total_kpi'] = round($total, 2);
            $update['jk_status'] = $this->hitungStatus($total);
        } else {
            $update['jk_total_kpi'] = null;
            $update['jk_status'] = null;
        }

        return $this->update($jk_id, $update);
    }

    public function kpi_delete($jk_id)
    {
        return $this->delete($jk_id);
    }

    public function get_distinct_divisi()
    {
        return $this->db->table($this->table)
            ->select('jk_divisi')
            ->distinct()
            ->where('jk_divisi IS NOT NULL')
            ->where('jk_divisi <>', '')
            ->orderBy('jk_divisi', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function get_distinct_karyawan()
    {
        return $this->db->table($this->table)
            ->select('jk_nama_karyawan')
            ->distinct()
            ->where('jk_nama_karyawan IS NOT NULL')
            ->where('jk_nama_karyawan <>', '')
            ->orderBy('jk_nama_karyawan', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function get_karyawan_by_divisi($divisi)
    {
        return $this->db->table($this->table)
            ->select('jk_nama_karyawan')
            ->distinct()
            ->where('jk_divisi', $divisi)
            ->where('jk_nama_karyawan IS NOT NULL')
            ->where('jk_nama_karyawan <>', '')
            ->orderBy('jk_nama_karyawan', 'ASC')
            ->get()
            ->getResultArray();
    }

}
