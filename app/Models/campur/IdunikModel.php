<?php

namespace App\Models\campur;

use CodeIgniter\Model;

class IDUnikModel extends Model
{
    protected $table      = 'id_unik';
    protected $allowedFields = ['usernama', 'idunik'];

    public function saveUnik($idunik)
    {
        $this->save(['usernama' => session()->usernama, 'idunik' => $idunik]);
    }

    public function cekUnik($idunik)
    {
        return $this->where(['idunik' => $idunik])->first();
    }
}
