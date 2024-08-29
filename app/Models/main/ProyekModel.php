<?php

namespace App\Models\main;

use CodeIgniter\Model;

class ProyekModel extends Model
{
    protected $table      = 'm_proyek';
    protected $allowedFields = [
        'idunik', 'kode', 'nama', 'paket', 'atasnama', 'lokasi', 'propinsi', 'kabupaten', 'pemilik', 'lingkup', 'carabayar', 'kate_id',
        'kbli_id', 'tgl_kontrak', 'tgl_pho', 'tgl_fho', 'ppn', 'pph', 'ni_kontrak', 'ni_tambah', 'ni_lain', 'ni_bruto', 'ni_ppn',
        'ni_pph', 'ni_netto', 'periode1', 'periode2', 'modeyear', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'konsultan', 'asuransi',
        'keuangan', 'pelaksanaan', 'catatan', 'is_pajak', 'kondisi', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
