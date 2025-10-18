<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home - ITE311 PINEDA',
            'active_page' => 'home',
            'content' => view('pages/home')
        ];
        return view('template', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About - ITE311 PINEDA',
            'active_page' => 'about',
            'content' => view('pages/about')
        ];
        return view('template', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact - ITE311 PINEDA',
            'active_page' => 'contact',
            'content' => view('pages/contact')
        ];
        return view('template', $data);
    }
}
