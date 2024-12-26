<?php

namespace App\Models\pembelian;

use CodeIgniter\Model;

class POmasukModel extends Model
{
    protected $table      = 'po_masuk';
    protected $allowedFields = [
        'popesan_id', 'poanak_id', 'tanggal', 'gudang_id', 'cabang_id', 'tiket', 'nopol', 'supir', 'jl_awal', 'jl_hasil', 'catatan'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getID($idunik = false)
    {
        return $this->where(['idunik' => $idunik])->first();
    }
}
