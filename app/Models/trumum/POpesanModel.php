<?php

namespace App\Models\pembelian;

use CodeIgniter\Model;

class POpesanModel extends Model
{
    protected $table      = 'po_pesan';
    protected $allowedFields = [
        'idunik', 'pominta_id', 'penerima_id', 'nodoc', 'tgl_po', 'tgl_masuk', 'tgl_rekap', 'tgl_lunas', 'st_pajak', 'total1', 'totppn', 'total2',
        'buktibayar', 'level_aw', 'level_pos', 'aksi', 'status'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getID($idunik = false)
    {
        return $this->where(['idunik' => $idunik])->first();
    }
}
