<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // aquí puedes pasar datos al panel si quieres
        return view('admin.dashboard');
    }
}
