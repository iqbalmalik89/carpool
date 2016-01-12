<?php

namespace App\Http\Controllers\Vehicle;

use App\Repositories\VehicleTypeRepository;
use App\Http\Requests\VehicleTypeRequest;
use App\Library\Uploader;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class VehicleTypeController extends Controller
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
    public function __construct(VehicleTypeRepository $vehicle_typeRepo)
    {
        $this->repo = $vehicle_typeRepo;
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
            'vehicle_type' => 'required',
            'pic_path' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);
    }

    public function verifyCode($code)
    {
        $resp = $this->repo->verifyCode($code);
        die();
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Vehicle Type created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Type not registered successfully.', 'code' => 400], 400);
        }
    }

    public function save(VehicleTypeRequest $request)
    {
        $resp = $this->repo->save($request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Vehicle Type created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Type not registered successfully.', 'code' => 400], 400);
        }
    }

    public function upload(VehicleTypeRequest $request)
    {
        $uploaderObj = new Uploader();
        $uploaderObj->size = array('width' =>100, 'height' => 100);
        $uploaderObj->directory = 'vehicle_type_images';
        $resp = $uploaderObj->uploadImage($request->file('vehicle_type_image_upload'));
        return response()->json($resp);
    }


    public function update(VehicleTypeRequest $request, $id)
    {
        $resp = $this->repo->update($id, $request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Vehicle Type updated successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Type not updated successfully.', 'code' => 400], 400);
        }
    }

    public function listing(VehicleTypeRequest $request)
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
            return response()->json(['status' => 'success', 'message' => 'Vehicle Type deleted successfully', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Type not found', 'code' => 404], 404);
        }
    }

    public function get($id)
    {
        $vehicle_typeData = $this->repo->get($id, false);
        if(!empty($vehicle_typeData))
        {
            return response()->json(['status' => 'success', 'message' => '', 'data' => $vehicle_typeData, 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Vehicle Type not found', 'code' => 404], 404);            
        }
    }

}
