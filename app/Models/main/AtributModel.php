<?php

namespace App\Models\file;

use CodeIgniter\Model;

class AtributModel extends Model
{
    protected $table      = 'm_atribut';
    protected $allowedFields = ['id_unik', 'pilihan', 'nourut', 'nilaikonstanta', 'satuan', 'nama', 'separator', 'is_confirm', 'is_aktif'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
