<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JobdescModel;

class Jobdescs extends BaseController
{
    protected $kpiModel;
    protected $session;

    public function __construct()
    {
        $this->kpiModel = new JobdescModel();
        $this->session = session();
        helper(['form', 'url']);
    }

    protected function validasi_indikator_input(&$indikator, &$bobot, &$n)
    {
        for ($i = 1; $i <= 12; $i++) {
            $indikator[$i] = trim((string) $this->request->getPost("jk_indikator_{$i}"));
            $bobot[$i] = trim((string) $this->request->getPost("jk_bobot_{$i}"));

            if ($indikator[$i] === '') {
                $indikator[$i] = null;
            }
            if ($bobot[$i] === '') {
                $bobot[$i] = null;
            }
        }

        $n = 0;
        for ($i = 1; $i <= 12; $i++) {
            $filled = ($indikator[$i] !== null || $bobot[$i] !== null);

            if (!$filled) {
                continue;
            }

            if ($i !== $n + 1) {
                return 'Indikator harus diisi berurutan mulai dari Indikator 1 tanpa melompat.';
            }

            $n = $i;
        }

        if ($n < 5) {
            return 'Minimal 5 indikator harus diisi. Jumlah indikator terisi saat ini: ' . $n . '.';
        }

        $totalBobot = 0;
        for ($i = 1; $i <= $n; $i++) {
            if ($indikator[$i] === null || $bobot[$i] === null) {
                return 'Detail indikator dan bobot nilai pada Indikator ' . $i . ' harus terisi berpasangan.';
            }

            if (!is_numeric($bobot[$i]) || (float) $bobot[$i] < 1 || (float) $bobot[$i] > 100) {
                return 'Bobot nilai Indikator ' . $i . ' harus berupa angka pada skala 1 - 100.';
            }

            $totalBobot += (float) $bobot[$i];
        }

        if (abs($totalBobot - 100) > 0.01) {
            return 'Total bobot seluruh indikator terisi harus tepat 100. Total saat ini: ' . round($totalBobot, 2) . '.';
        }

        return null;
    }

    public function kpi_list()
    {
        $data['kpilist'] = $this->kpiModel->getall_kpi_lengkap();
        return view('jobdesc/kpi_management', $data);
    }

    public function kpi_nilai_list()
    {
        $data['kpilist'] = $this->kpiModel->getall_kpi_pending();
        return view('jobdesc/kpi_nilai_management', $data);
    }

    public function add_indikator()
    {
        return view('jobdesc/kpi_add_indikator');
    }

    public function insert_indikator()
    {
        $divisi = trim((string) $this->request->getPost('jk_divisi'));
        $karyawan = trim((string) $this->request->getPost('jk_nama_karyawan'));

        if ($divisi === '' || $karyawan === '') {
            return redirect()->back()->with('warningmessage', 'Nama divisi dan nama karyawan wajib diisi.');
        }

        $err = $this->validasi_indikator_input($indikator, $bobot, $n);

        if ($err !== null) {
            return redirect()->back()->with('warningmessage', $err);
        }

        $data = [
            'jk_divisi' => $divisi,
            'jk_nama_karyawan' => $karyawan,
            'jk_created_by' => $this->session->get('name') ?? 'None',
        ];

        for ($i = 1; $i <= 12; $i++) {
            if ($i <= $n) {
                $data["jk_indikator_{$i}"] = $indikator[$i];
                $data["jk_bobot_{$i}"] = round((float) $bobot[$i] / 100, 2);
            } else {
                $data["jk_indikator_{$i}"] = null;
                $data["jk_bobot_{$i}"] = null;
            }
        }

        $this->kpiModel->insert_indikator($data);

        return redirect()->to('jobdesc/kpi_nilai_management')->with('successmessage', 'Indikator KPI (' . $n . ' indikator) berhasil ditambahkan. Silakan isi nilai indikator.');
    }

    public function edit_indikator($jk_id)
    {
        $data['kpi'] = $this->kpiModel->get_kpi_detail($jk_id);

        if (empty($data['kpi'])) {
            return redirect()->to('jobdesc/kpi_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        return view('jobdesc/kpi_add_indikator', $data);
    }

    public function update_indikator()
    {
        $jk_id = $this->request->getPost('jk_id');

        if (empty($jk_id)) {
            return redirect()->to('jobdesc/kpi_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        $kpi = $this->kpiModel->get_kpi_detail($jk_id);

        if (empty($kpi)) {
            return redirect()->to('jobdesc/kpi_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        $divisi = trim((string) $this->request->getPost('jk_divisi'));
        $karyawan = trim((string) $this->request->getPost('jk_nama_karyawan'));

        if ($divisi === '' || $karyawan === '') {
            return redirect()->back()->with('warningmessage', 'Nama divisi dan nama karyawan wajib diisi.');
        }

        $err = $this->validasi_indikator_input($indikator, $bobot, $n);

        if ($err !== null) {
            return redirect()->back()->with('warningmessage', $err);
        }

        $lengkapOld = $this->kpiModel->isLengkap($kpi);

        $data = [
            'jk_divisi' => $divisi,
            'jk_nama_karyawan' => $karyawan,
        ];

        for ($i = 1; $i <= 12; $i++) {
            if ($i <= $n) {
                $data["jk_indikator_{$i}"] = $indikator[$i];
                $data["jk_bobot_{$i}"] = round((float) $bobot[$i] / 100, 2);
            } else {
                $data["jk_indikator_{$i}"] = null;
                $data["jk_bobot_{$i}"] = null;
                $data["jk_nilai_{$i}"] = null;
            }
        }

        if ($lengkapOld) {
            for ($i = 1; $i <= $n; $i++) {
                $nilai = trim((string) $this->request->getPost("jk_nilai_{$i}"));

                if ($nilai === '' || !is_numeric($nilai) || (float) $nilai < 1 || (float) $nilai > 100) {
                    return redirect()->back()->with('warningmessage', 'Nilai Indikator ' . $i . ' wajib terisi pada skala 1 - 100.');
                }

                $data["jk_nilai_{$i}"] = round((float) $nilai, 2);
            }
        }

        $this->kpiModel->update_indikator($jk_id, $data);

        $kpiBaru = $this->kpiModel->get_kpi_detail($jk_id);

        if ($this->kpiModel->isLengkap($kpiBaru)) {
            return redirect()->to('jobdesc/kpi_management')->with('successmessage', 'Indikator & nilai KPI berhasil diupdate.');
        }

        return redirect()->to('jobdesc/kpi_nilai_management')->with('successmessage', 'Indikator KPI berhasil diupdate.');
    }

    public function add_nilai($jk_id)
    {
        $data['kpi'] = $this->kpiModel->get_kpi_detail($jk_id);

        if (empty($data['kpi'])) {
            return redirect()->to('jobdesc/kpi_nilai_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        return view('jobdesc/kpi_add_nilai', $data);
    }

    public function insert_nilai()
    {
        $jk_id = $this->request->getPost('jk_id');

        if (empty($jk_id)) {
            return redirect()->to('jobdesc/kpi_nilai_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        $kpi = $this->kpiModel->get_kpi_detail($jk_id);

        if (empty($kpi)) {
            return redirect()->to('jobdesc/kpi_nilai_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        $nilai = [];

        for ($i = 1; $i <= 12; $i++) {
            $filled = $kpi["jk_indikator_{$i}"] !== null && $kpi["jk_indikator_{$i}"] !== '';

            if ($filled) {
                $value = trim((string) $this->request->getPost("jk_nilai_{$i}"));

                if ($value === '' || !is_numeric($value) || (float) $value < 1 || (float) $value > 100) {
                    return redirect()->back()->with('warningmessage', 'Nilai Indikator ' . $i . ' wajib terisi pada skala 1 - 100.');
                }

                $nilai["jk_nilai_{$i}"] = round((float) $value, 2);
            } else {
                $nilai["jk_nilai_{$i}"] = null;
            }
        }

        $this->kpiModel->insert_nilai($jk_id, $nilai);

        return redirect()->to('jobdesc/kpi_management')->with('successmessage', 'Nilai KPI berhasil disimpan dan sudah dikonversi dengan bobot indikator.');
    }

    public function view_kpi($jk_id)
    {
        $data['kpi'] = $this->kpiModel->get_kpi_detail($jk_id);

        if (empty($data['kpi'])) {
            return redirect()->to('jobdesc/kpi_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        return view('jobdesc/kpi_view', $data);
    }

    public function view_kpi_nilai($jk_id)
    {
        $data['kpi'] = $this->kpiModel->get_kpi_detail($jk_id);

        if (empty($data['kpi'])) {
            return redirect()->to('jobdesc/kpi_nilai_management')->with('warningmessage', 'Data KPI tidak ditemukan.');
        }

        return view('jobdesc/kpi_nilai_view', $data);
    }

    public function kpi_delete($jk_id)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('jobdesc/kpi_management');
        }

        $returndata = $this->kpiModel->kpi_delete($jk_id);

        if ($returndata) {
            return redirect()->back()->with('successmessage', 'Data KPI berhasil dihapus.');
        }

        return redirect()->back()->with('warningmessage', 'Gagal menghapus data KPI.');
    }

}
