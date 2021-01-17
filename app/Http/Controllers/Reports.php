<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Reports extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Reports'
        ];

        return view('posts.reports', $data);
    }
}
