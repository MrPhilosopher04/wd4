<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController
{
    public function pimpinan()
    {
        return view('auth.pimpinan');
    }

    public function jurusan()
    {
        return view('auth.jurusan');
    }

    public function unit()
    {
        return view('auth.unit');
    }

    public function admin()
    {
        return view('admin.dashboard');
    }
}
