<?php

namespace App\Models\main;

use CodeIgniter\Model;

class AttachmentModel extends Model
{
    protected $table      = 'm_attachment';
    protected $allowedFields = [
        'unique',
        'object',
        'object_uniq',
        'category',
        'keeper',
        'title',
        'description',
        'ska',
        'level',
        'qualification',
        'registration_number',
        'association',
        'year',
        'company_id',
        'region_id',
        'division_id',
        'start_date',
        'end_date',
        'attachment',
        'is_active',
        'save_by',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getAttachment($object, $unique)
    {
        $query = $this->db->table('m_attachment');
        $query->select('m_attachment.*, m_user.code as user');
        $query->join('m_user', 'm_attachment.save_by = m_user.id', 'left');
        $query->where('m_attachment.object', $object)->where('m_attachment.object_uniq', $unique);
        return $query->get()->getResultArray();
    }
}
