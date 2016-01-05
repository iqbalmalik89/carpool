<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class UserRequest extends FormRequest
{

    public function rules()
    {
    	$method = $this->method();
    	$route = \Route::getCurrentRoute()->getPath();

		switch($method)
	    {
	        case 'GET':
	        {

	        }
	        case 'DELETE':
	        {
	            return [];
	        }
	        case 'POST':
	        {
				if($route == 'api/users/image')
	        	{
					return [
			            'user_image_upload' => 'required|image',
			        ];	        		
	        	}
	        	else
	        	{
			        return [
			            'first_name' => 'required',
			            'last_name' => 'required',            
			            'mobile' => 'required',
			            'email' => 'required|unique:site_users',
			            'password' => 'required',
			        ];	        		
	        	}
	        }
	        case 'PUT':
	        {
				return [
		            'first_name' => 'required',
		            'last_name' => 'required',            
		            'mobile' => 'required',
		            'email' => 'unique:site_users,email,'.\Request::input('user_id'),
		        ];	     
	        }
	        case 'PATCH':
	        {

	        }
	        default:break;
	    }


    }




    public function authorize()
    {
        // Only allow logged in users
        //return \Auth::check();
        // Allows all users in
        return true;
    }

    // OPTIONAL OVERRIDE
    // public function forbiddenResponse()
    // {
    //     // Optionally, send a custom response on authorize failure 
    //     // (default is to just redirect to initial page with errors)
    //     // 
    //     // Can return a response, a view, a redirect, or whatever else
    //     return Response::make('Permission denied foo!', 403);
    // }

    public function response(array $errors) {
        return response()->json(['status' => 'error', 'message' => $errors, 'code' => 400], 400);
    }

}
