<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'course_id', 'enrollment_date', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'course_id' => 'required|integer',
        'enrollment_date' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required.',
            'integer' => 'User ID must be a valid integer.'
        ],
        'course_id' => [
            'required' => 'Course ID is required.',
            'integer' => 'Course ID must be a valid integer.'
        ],
        'enrollment_date' => [
            'required' => 'Enrollment date is required.',
            'valid_date' => 'Enrollment date must be a valid date.'
        ]
    ];

    /**
     * Enroll a user in a course
     * 
     * @param array $data
     * @return bool|int
     */
    public function enrollUser($data)
    {
        // Validate required fields
        if (!isset($data['user_id']) || !isset($data['course_id'])) {
            return false;
        }

        // Check if already enrolled
        if ($this->isAlreadyEnrolled($data['user_id'], $data['course_id'])) {
            return false;
        }

        // Set enrollment date if not provided
        if (!isset($data['enrollment_date'])) {
            $data['enrollment_date'] = date('Y-m-d H:i:s');
        }

        // Insert enrollment record
        return $this->insert($data);
    }

    /**
     * Get all courses a user is enrolled in
     * 
     * @param int $user_id
     * @return array
     */
    public function getUserEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.title, courses.description, users.name as instructor_name')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->join('users', 'users.id = courses.instructor_id')
                    ->where('enrollments.user_id', $user_id)
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Check if a user is already enrolled in a specific course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function isAlreadyEnrolled($user_id, $course_id)
    {
        $enrollment = $this->where('user_id', $user_id)
                          ->where('course_id', $course_id)
                          ->first();
        
        return $enrollment !== null;
    }

    /**
     * Get enrollment statistics
     * 
     * @return array
     */
    public function getEnrollmentStats()
    {
        $db = \Config\Database::connect();
        
        $stats = [];
        
        // Total enrollments
        $stats['total_enrollments'] = $this->countAllResults();
        
        // Enrollments by course
        $stats['enrollments_by_course'] = $db->query("
            SELECT c.title, COUNT(e.id) as enrollment_count 
            FROM courses c 
            LEFT JOIN enrollments e ON c.id = e.course_id 
            GROUP BY c.id, c.title 
            ORDER BY enrollment_count DESC
        ")->getResultArray();
        
        // Recent enrollments
        $stats['recent_enrollments'] = $this->select('enrollments.*, users.name as user_name, courses.title as course_title')
                                           ->join('users', 'users.id = enrollments.user_id')
                                           ->join('courses', 'courses.id = enrollments.course_id')
                                           ->orderBy('enrollments.enrollment_date', 'DESC')
                                           ->limit(10)
                                           ->findAll();
        
        return $stats;
    }

    /**
     * Get available courses for a user (not enrolled)
     * 
     * @param int $user_id
     * @return array
     */
    public function getAvailableCourses($user_id)
    {
        $db = \Config\Database::connect();
        
        return $db->query("
            SELECT c.*, u.name as instructor_name 
            FROM courses c 
            JOIN users u ON u.id = c.instructor_id
            WHERE c.id NOT IN (
                SELECT e.course_id 
                FROM enrollments e 
                WHERE e.user_id = ?
            )
        ", [$user_id])->getResultArray();
    }

    /**
     * Unenroll a user from a course
     * 
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    public function unenrollUser($user_id, $course_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('course_id', $course_id)
                    ->delete();
    }
}
