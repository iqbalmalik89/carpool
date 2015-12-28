<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function showLogin()
  {
    return view('admin/login');
  }

  public function showDashboard()
  {
    return view('admin/dashboard');
  }

  public function showUser()
  {
    return view('admin/users');
  }

  public function showCarMake()
  {
    return view('admin/car/make');
  }

  public function showProfile()
  {
    return view('admin/profile');
  }
}
