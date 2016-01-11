<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class VehicleCategoryRequest extends FormRequest
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
	    
			        return [
			            'category' => 'required|unique:vehicle_category',
			            'status' => 'required',            
			            
			        ];	        		
	       
	        }
	        case 'PUT':
	        {
				return [

			            'category' => 'unique:vehicle_category,category,'.\Request::input('id'),
			            'status' => 'required',            
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
