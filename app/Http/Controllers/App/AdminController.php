<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SystemUserRepository;

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
    $repo = new SystemUserRepository();
    $response = $repo->getUserByCol('code', $code, 'active');
    if(!empty($response))
    {
      return view('admin/user/login', array('access' => true,
                                            'code' => $code,
                                            'user_id' => $response->id
                                           ));
    }
    else
    {
      return view('admin/user/login', array('access' => false,
                                           ));
    }
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
