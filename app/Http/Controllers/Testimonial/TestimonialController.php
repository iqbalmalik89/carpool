<?php

namespace App\Http\Controllers\Testimonial;

use App\Repositories\TestimonialRepository;
use App\Http\Requests\TestimonialRequest;
use App\Library\Uploader;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class TestimonialController extends Controller
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
    public function __construct(TestimonialRepository $testimonialRepo)
    {
        $this->repo = $testimonialRepo;
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
            'name' => 'required',
            'description' => 'required',
            'pic_path' => 'required',
            'status' => 'required',
        ]);
    }

    public function verifyCode($code)
    {
        $resp = $this->repo->verifyCode($code);
        die();
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Testimonial created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Testimonial not registered successfully.', 'code' => 400], 400);
        }
    }

    public function save(TestimonialRequest $request)
    {
        $resp = $this->repo->save($request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Testimonial created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Testimonial not registered successfully.', 'code' => 400], 400);
        }
    }

    public function upload(TestimonialRequest $request)
    {
        $uploaderObj = new Uploader();
        $uploaderObj->size = array('width' =>100, 'height' => 100);
        $uploaderObj->directory = 'testimonial_images';
        $resp = $uploaderObj->uploadImage($request->file('user_image_upload'));
        return response()->json($resp);
    }

    public function update(TestimonialRequest $request, $id)
    {
        $resp = $this->repo->update($id, $request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Testimonial updated successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Testimonial not updated successfully.', 'code' => 400], 400);
        }
    }

    public function listing(TestimonialRequest $request)
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
            return response()->json(['status' => 'success', 'message' => 'Testimonial deleted successfully', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Testimonial not found', 'code' => 404], 404);
        }
    }

    public function get($id)
    {
        $testimonialData = $this->repo->get($id, false);
        if(!empty($testimonialData))
        {
            return response()->json(['status' => 'success', 'message' => '', 'data' => $testimonialData, 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Testimonial not found', 'code' => 404], 404);            
        }
    }

}
