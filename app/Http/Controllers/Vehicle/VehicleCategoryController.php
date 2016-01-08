<?php

namespace App\Http\Controllers\Vehicle;

use App\Repositories\VehicleCategoryRepository;
use App\Http\Requests\VehicleCategoryRequest;
use App\Library\Uploader;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class VehicleCategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    public $repo = '';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(VehicleCategoryRepository $vehicle_categoryRepo)
    {
        $this->repo = $vehicle_categoryRepo;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'category' => 'required',
            'status' => 'required',
        ]);
    }

    public function verifyCode($code)
    {
        $resp = $this->repo->verifyCode($code);
        die();
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Vehicle Category created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Category not registered successfully.', 'code' => 400], 400);
        }
    }

    public function save(VehicleCategoryRequest $request)
    {
        $resp = $this->repo->save($request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Vehicle Category created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Category not registered successfully.', 'code' => 400], 400);
        }
    }

  

    public function update(VehicleCategoryRequest $request, $id)
    {
        $resp = $this->repo->update($id, $request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Vehicle Category updated successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Category not updated successfully.', 'code' => 400], 400);
        }
    }

    public function listing(VehicleCategoryRequest $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');

        $resp = $this->repo->listing($page, $limit);
        if(!empty($resp))
        {
            return response()->json(['status' => 'success', 'data' => $resp, 'code' => 200], 200);
        }
    }

    public function destroy($id)
    {
        $response = $this->repo->destroy($id);
        if(!empty($response))
        {
            return response()->json(['status' => 'success', 'message' => 'Vehicle Category deleted successfully', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Category not found', 'code' => 404], 404);
        }
    }

    public function get($id)
    {
        $vehicle_categoryData = $this->repo->get($id, false);
        if(!empty($vehicle_categoryData))
        {
            return response()->json(['status' => 'success', 'message' => '', 'data' => $vehicle_categoryData, 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Category not found', 'code' => 404], 404);            
        }
    }

}
