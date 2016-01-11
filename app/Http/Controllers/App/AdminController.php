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
    return view('admin/system-users/login');
  }

  public function showDashboard()
  {
    return view('admin/system-users/dashboard');
  }

  public function showResetPassword($code)
  {
    $repo = new SystemUserRepository();
    $response = $repo->getUserByCol('code', $code, 'active');
    if(!empty($response))
    {
      return view('admin/system-users/login', array('access' => true,
                                            'code' => $code,
                                            'user_id' => $response->id
                                           ));
    }
    else
    {
      return view('admin/system-users/login', array('access' => false,
                                           ));
    }
  }

  public function showSubscriber()
  {
    return view('admin/emails/subscriber');    
  }

  public function showVehicleCat()
  {
    return view('admin/vehicle/vehicle_cat');
  }  

  public function showUser()
  {
    return view('admin/site-users/users');
  }

  public function showSystemUser()
  {
    return view('admin/system-users/users');
  }

  public function showCarMake()
  {
    return view('admin/car/make');
  }

  public function showProfile()
  {
    return view('admin/system-users/profile');
  }

  public function showCountry()
  {
    return view('admin/location/country');
  }  

  public function showLanguage()
  {
    return view('admin/location/language');
  }

  public function showCurrency()
  {
    return view('admin/location/currency');
  }    
  
  public function showTestimonial()
  {
    return view('admin/testimonial/testimonial');    
  }
  
  public function showradius()
  {
    return view('admin/location/radius');
  }  
}
