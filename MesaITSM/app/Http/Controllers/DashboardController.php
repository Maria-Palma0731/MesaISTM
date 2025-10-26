<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Placeholder data; replace with real model queries as you add models
        $data = [
            'tickets_count' => 12,
            'services_count' => 8,
            'knowledge_articles_count' => 23,
        ];

        return view('dashboard', $data);
    }
}
