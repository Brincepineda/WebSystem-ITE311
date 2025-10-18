<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends Controller
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
            'title' => 'Admin Dashboard - ITE311 PINEDA',
            'active_page' => 'admin_dashboard',
            'content' => view('admin/dashboard', [
                'user' => [
                    'name' => $this->session->get('name'),
                    'role' => $this->session->get('role')
                ]
            ])
        ];

        return view('template', $data);
    }

    public function users()
    {
        $data = [
            'title' => 'Manage Users - Admin Panel',
            'active_page' => 'admin_users',
            'content' => view('admin/users')
        ];

        return view('template', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'System Settings - Admin Panel',
            'active_page' => 'admin_settings',
            'content' => view('admin/settings')
        ];

        return view('template', $data);
    }

    public function reports()
    {
        $data = [
            'title' => 'Reports - Admin Panel',
            'active_page' => 'admin_reports',
            'content' => view('admin/reports')
        ];

        return view('template', $data);
    }
}
