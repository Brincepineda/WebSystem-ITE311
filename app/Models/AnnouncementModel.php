<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['title', 'content', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'content' => 'required|min_length[10]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Announcement title is required.',
            'min_length' => 'Title must be at least 3 characters long.',
            'max_length' => 'Title cannot exceed 255 characters.'
        ],
        'content' => [
            'required' => 'Announcement content is required.',
            'min_length' => 'Content must be at least 10 characters long.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get all announcements ordered by created_at descending (newest first)
     *
     * @return array
     */
    public function getAllAnnouncements()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get recent announcements with limit
     *
     * @param int $limit
     * @return array
     */
    public function getRecentAnnouncements($limit = 5)
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}
