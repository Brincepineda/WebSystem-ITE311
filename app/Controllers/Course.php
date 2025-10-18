<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Course extends Controller
{
    protected $enrollmentModel;
    protected $courseModel;
    protected $session;

    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
        $this->courseModel = new CourseModel();
        $this->session = \Config\Services::session();
        
        // Security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
    }

    /**
     * Handle AJAX enrollment requests
     */
    public function enroll()
    {
        // Set JSON response header
        $this->response->setContentType('application/json');
        
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to enroll in courses.',
                'redirect' => site_url('/login')
            ])->setStatusCode(401);
        }

        // Check if request is POST
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ])->setStatusCode(405);
        }

        // Validate CSRF token (temporarily disabled for testing)
        // TODO: Re-enable CSRF validation after testing
        /*
        $validation = \Config\Services::validation();
        if (!$validation->check($this->request->getPost(csrf_token()), 'required')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid security token. Please refresh the page and try again.'
            ])->setStatusCode(403);
        }
        */

        // Get course ID from request
        $courseId = $this->request->getPost('course_id');
        $userId = $this->session->get('userID');

        // Validate course ID
        if (!$courseId || !is_numeric($courseId) || $courseId <= 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid course ID provided.'
            ])->setStatusCode(400);
        }

        // Rate limiting - prevent spam enrollments
        $lastEnrollment = $this->session->get('last_enrollment_time');
        if ($lastEnrollment && (time() - $lastEnrollment) < 2) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please wait before making another enrollment request.'
            ])->setStatusCode(429);
        }

        // Check if course exists
        $course = $this->courseModel->find($courseId);
        if (!$course) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course not found.'
            ])->setStatusCode(404);
        }

        // Check if user is already enrolled
        if ($this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are already enrolled in this course.'
            ])->setStatusCode(409);
        }

        // Only students can enroll in courses
        if ($this->session->get('role') !== 'student') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only students can enroll in courses.'
            ])->setStatusCode(403);
        }

        // Prepare enrollment data
        $enrollmentData = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s')
        ];

        // Attempt to enroll user
        $enrollmentId = $this->enrollmentModel->enrollUser($enrollmentData);

        if ($enrollmentId) {
            // Update rate limiting timestamp
            $this->session->set('last_enrollment_time', time());
            
            // Log the enrollment for security audit
            log_message('info', "User {$userId} enrolled in course {$courseId}");
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully enrolled in ' . esc($course['title']) . '!',
                'enrollment_id' => $enrollmentId,
                'course_title' => esc($course['title'])
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to enroll in course. Please try again.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Handle AJAX unenrollment requests
     */
    public function unenroll()
    {
        // Set JSON response header
        $this->response->setContentType('application/json');
        
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to unenroll from courses.'
            ])->setStatusCode(401);
        }

        // Check if request is POST
        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ])->setStatusCode(405);
        }

        // Get course ID and user ID
        $courseId = $this->request->getPost('course_id');
        $userId = $this->session->get('userID');

        // Validate course ID
        if (!$courseId || !is_numeric($courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid course ID provided.'
            ])->setStatusCode(400);
        }

        // Check if user is enrolled
        if (!$this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are not enrolled in this course.'
            ])->setStatusCode(409);
        }

        // Attempt to unenroll user
        if ($this->enrollmentModel->unenrollUser($userId, $courseId)) {
            // Log the unenrollment
            log_message('info', "User {$userId} unenrolled from course {$courseId}");
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully unenrolled from course.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to unenroll from course. Please try again.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Get available courses for AJAX requests
     */
    public function getAvailableCourses()
    {
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Authentication required.'
            ])->setStatusCode(401);
        }

        $userId = $this->session->get('userID');
        $availableCourses = $this->enrollmentModel->getAvailableCourses($userId);

        return $this->response->setJSON([
            'success' => true,
            'courses' => $availableCourses
        ]);
    }

    /**
     * Get user enrollments for AJAX requests
     */
    public function getUserEnrollments()
    {
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Authentication required.'
            ])->setStatusCode(401);
        }

        $userId = $this->session->get('userID');
        $enrollments = $this->enrollmentModel->getUserEnrollments($userId);

        return $this->response->setJSON([
            'success' => true,
            'enrollments' => $enrollments
        ]);
    }
}
