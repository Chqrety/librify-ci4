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
        echo "<h1>Dashboard Admin Librify</h1>";
        echo "<p>Selamat datang, " . session()->get('name') . "</p>";
        echo "<a href='/logout'>Logout</a>";
    }
}
