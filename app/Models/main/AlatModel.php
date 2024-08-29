<?php

namespace App\Models\main;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table      = 'm_alat';
    protected $allowedFields = [
        'idunik', 'param', 'rekan_id', 'kode', 'nomor', 'nama', 'model', 'merk', 'kategori', 'jenis', 'pegawai_id', 'sumberdaya_id',
        'kbli_id', 'kakun_id', 'bukti', 'ibbm', 'berat', 'tgl_beli', 'tgl_produksi', 'tgl_stnk', 'tgl_keur', 'mode_susut', 'umur',
        'sisa', 'ni_beli', 'ni_residu', 'ni_sewa', 'ni_susut', 'perusahaan_id', 'wilayah_id', 'divisi_id', 'perusahaanin_id', 'gambar',
        'dokumen', 'mesin', 'transmisi', 'catatan', 'is_jual', 'kondisi', 'nolink', 'save_by', 'conf_by', 'aktif_by'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
