<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function index()
    {
        //
    }

    public function dashboard()
    {
        $data = ['title' => 'Dashboard Admin'];
        return view('admin/dashboard', $data);
    }
}
