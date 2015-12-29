<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function showLogin()
  {
    return view('admin/user/login');
  }

  public function showDashboard()
  {
    return view('admin/user/dashboard');
  }

  public function showResetPassword($code)
  {
    
  }

  public function showUser()
  {
    return view('admin/user/users');
  }

  public function showCarMake()
  {
    return view('admin/car/make');
  }

  public function showProfile()
  {
    return view('admin/user/profile');
  }
}
