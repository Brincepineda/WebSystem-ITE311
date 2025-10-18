<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['title', 'description', 'instructor_id', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[10]',
        'instructor_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Course title is required.',
            'min_length' => 'Course title must be at least 3 characters long.',
            'max_length' => 'Course title cannot exceed 255 characters.'
        ],
        'description' => [
            'required' => 'Course description is required.',
            'min_length' => 'Course description must be at least 10 characters long.'
        ],
        'instructor_id' => [
            'required' => 'Instructor is required.',
            'integer' => 'Instructor ID must be a valid number.'
        ]
    ];

    /**
     * Get all active courses
     * 
     * @return array
     */
    public function getActiveCourses()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get course with enrollment count
     * 
     * @param int $courseId
     * @return array|null
     */
    public function getCourseWithEnrollmentCount($courseId)
    {
        $db = \Config\Database::connect();
        
        return $db->query("
            SELECT c.*, COUNT(e.id) as enrollment_count 
            FROM courses c 
            LEFT JOIN enrollments e ON c.id = e.course_id 
            WHERE c.id = ? 
            GROUP BY c.id
        ", [$courseId])->getRowArray();
    }

    /**
     * Get courses by instructor
     * 
     * @param string $instructor
     * @return array
     */
    public function getCoursesByInstructor($instructor)
    {
        return $this->where('instructor', $instructor)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
