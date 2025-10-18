<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Teacher extends Controller
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        
        // Security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Teacher Dashboard - ITE311 PINEDA',
            'active_page' => 'teacher_dashboard',
            'content' => view('teacher/dashboard', [
                'user' => [
                    'name' => $this->session->get('name'),
                    'role' => $this->session->get('role')
                ]
            ])
        ];

        return view('template', $data);
    }

    public function courses()
    {
        $data = [
            'title' => 'My Courses - Teacher Panel',
            'active_page' => 'teacher_courses',
            'content' => view('teacher/courses')
        ];

        return view('template', $data);
    }

    public function students()
    {
        $data = [
            'title' => 'My Students - Teacher Panel',
            'active_page' => 'teacher_students',
            'content' => view('teacher/students')
        ];

        return view('template', $data);
    }

    public function grades()
    {
        $data = [
            'title' => 'Manage Grades - Teacher Panel',
            'active_page' => 'teacher_grades',
            'content' => view('teacher/grades')
        ];

        return view('template', $data);
    }
}
