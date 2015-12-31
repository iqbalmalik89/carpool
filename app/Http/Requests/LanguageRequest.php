<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class LanguageRequest extends FormRequest
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
	    //     	if($route == 'api/auth/login')
	    //     	{
			  //       return [
			  //           'email' => 'required',
			  //           'password' => 'required',
			  //       ];
	    //     	}
	    //     	else if($route == 'api/auth/forgot')
	    //     	{
			  //       return [
			  //           'email' => 'required',
			  //       ];
	    //     	}
	    //     	else if($route == 'api/system_users/image')
	    //     	{
					// return [
			  //           'user_image_upload' => 'required|image',
			  //       ];	        		
	    //     	}
	    //     	else if($route == 'api/auth/password')
	    //     	{
					// return [
			  //           'old_password' => 'required',
			  //           'new_password' => 'required',
			  //           'confirm_password' => 'required',
			  //       ];	        		
	    //     	}	        	
	        	// else
	        	// {
			        return [
			            'language' => 'required|unique:language',
			            'code' => 'required',            
			            
			        ];	        		
	        	//}
	        }
	        case 'PUT':
	        {
				return [

			            'language' => 'unique:language,language,'.\Request::input('language_id'),
			            'code' => 'required',            
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
