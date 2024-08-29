<?php

namespace App\Models\pembelian;

use CodeIgniter\Model;

class PObiayaModel extends Model
{
    protected $table      = 'po_biayaplus';
    protected $allowedFields = ['idunik_po', 'nobukti', 'poanak_id', 'akun_id', 'jumlah', 'biaya', 'catatan'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getID($idunik = false)
    {
        return $this->where(['idunik' => $idunik])->first();
    }
}
