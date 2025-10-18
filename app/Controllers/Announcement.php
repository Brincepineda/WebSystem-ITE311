<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AnnouncementModel;

class Announcement extends Controller
{
    protected $db;
    protected $session;
    protected $announcementModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->announcementModel = new AnnouncementModel();
        
        // Security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
    }

    public function index()
    {
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Fetch all announcements from database using AnnouncementModel
        try {
            $announcements = $this->announcementModel->getAllAnnouncements();
        } catch (\Exception $e) {
            $announcements = [];
        }

        // Prepare data for view
        $viewData = [
            'announcements' => $announcements
        ];

        $data = [
            'title' => 'Announcements - ITE311 PINEDA',
            'active_page' => 'announcements',
            'content' => view('announcements', $viewData)
        ];

        // Load view with template
        return view('template', $data);
    }

    /**
     * Admin method to manage announcements
     */
    public function manage()
    {
        // Check if user is logged in and is admin
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        if ($this->session->get('role') !== 'admin') {
            return redirect()->to('/announcements')->with('error', 'Access denied. Admin privileges required.');
        }

        // Fetch all announcements for management
        try {
            $announcements = $this->announcementModel->getAllAnnouncements();
        } catch (\Exception $e) {
            $announcements = [];
        }

        $viewData = [
            'announcements' => $announcements
        ];

        $data = [
            'title' => 'Manage Announcements - ITE311 PINEDA',
            'active_page' => 'announcements',
            'content' => view('announcements/manage', $viewData)
        ];

        return view('template', $data);
    }

    /**
     * Create new announcement
     */
    public function create()
    {
        // Check if user is logged in and is admin
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        if ($this->session->get('role') !== 'admin') {
            return redirect()->to('/announcements')->with('error', 'Access denied. Admin privileges required.');
        }

        if ($this->request->getMethod() === 'POST') {
            // Process form submission
            $data = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content')
            ];

            if ($this->announcementModel->insert($data)) {
                return redirect()->to('/announcements/manage')->with('success', 'Announcement created successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create announcement. Please try again.');
            }
        }

        // Show create form
        $data = [
            'title' => 'Create Announcement - ITE311 PINEDA',
            'active_page' => 'announcements',
            'content' => view('announcements/create')
        ];

        return view('template', $data);
    }

    /**
     * Edit existing announcement
     */
    public function edit($id = null)
    {
        // Check if user is logged in and is admin
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        if ($this->session->get('role') !== 'admin') {
            return redirect()->to('/announcements')->with('error', 'Access denied. Admin privileges required.');
        }

        if (!$id) {
            return redirect()->to('/announcements/manage')->with('error', 'Invalid announcement ID.');
        }

        $announcement = $this->announcementModel->find($id);
        if (!$announcement) {
            return redirect()->to('/announcements/manage')->with('error', 'Announcement not found.');
        }

        if ($this->request->getMethod() === 'POST') {
            // Process form submission
            $data = [
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content')
            ];

            if ($this->announcementModel->update($id, $data)) {
                return redirect()->to('/announcements/manage')->with('success', 'Announcement updated successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update announcement. Please try again.');
            }
        }

        // Show edit form
        $viewData = [
            'announcement' => $announcement
        ];

        $data = [
            'title' => 'Edit Announcement - ITE311 PINEDA',
            'active_page' => 'announcements',
            'content' => view('announcements/edit', $viewData)
        ];

        return view('template', $data);
    }

    /**
     * Delete announcement
     */
    public function delete($id = null)
    {
        // Check if user is logged in and is admin
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        if ($this->session->get('role') !== 'admin') {
            return redirect()->to('/announcements')->with('error', 'Access denied. Admin privileges required.');
        }

        if (!$id) {
            return redirect()->to('/announcements/manage')->with('error', 'Invalid announcement ID.');
        }

        if ($this->announcementModel->delete($id)) {
            return redirect()->to('/announcements/manage')->with('success', 'Announcement deleted successfully!');
        } else {
            return redirect()->to('/announcements/manage')->with('error', 'Failed to delete announcement. Please try again.');
        }
    }
}
