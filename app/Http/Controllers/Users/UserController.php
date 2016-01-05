<?php

namespace App\Http\Controllers\Users;

use App\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Library\Uploader;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class UserController extends Controller
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
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:site_users',
            'password' => 'required|confirmed|min:6',
        ]);
    }


    public function verifyCode($code)
    {
        $resp = $this->repo->verifyCode($code);
        die();
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'User created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'User not registered successfully.', 'code' => 400], 400);
        }
    }

    public function save(UserRequest $request)
    {
        $resp = $this->repo->save($request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'User created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'User not registered successfully.', 'code' => 400], 400);
        }
    }

    public function update(UserRequest $request)
    {
        $resp = $this->repo->update($request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'User updated successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'User not updated successfully.', 'code' => 400], 400);
        }
    }

    public function listing(UserRequest $request)
    {
        $page = $request->input('page');
        $limit = $request->input('limit');

        $resp = $this->repo->listing($page, $limit);
        if(!empty($resp))
        {
            return response()->json(['status' => 'success', 'data' => $resp, 'code' => 200], 200);
        }
    }

    public function login(UserRequest $request)
    {
        // Login user
        $response = $this->repo->login($request);
        if($response === 'inactive')
        {
            return response()->json(['status' => 'error', 'message' => 'Your account is disabled by user', 'code' => 400], 400);
        }
        else if(!empty($response))
        {
            // get user data
            $getUserData = $this->repo->get($response, false);

            if(!empty($getUserData))
            {
                // data user session
                $this->repo->setUserSession($getUserData);

                return response()->json(['status' => 'success', 'message' => 'User logged in successfully', 'code' => 200], 200);
            }
            else
            {
                return response()->json(['status' => 'error', 'message' => 'User not found', 'code' => 404], 404);
            }
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Email or password is wrong', 'code' => 200], 200);
        }
    }

    public function upload(UserRequest $request)
    {
        $uploaderObj = new Uploader();
        $uploaderObj->size = array('width' =>100, 'height' => 100);
        $uploaderObj->directory = 'site_user_images';
        $resp = $uploaderObj->uploadImage($request->file('user_image_upload'));
        return response()->json($resp);
    }

    public function resetPassword(UserRequest $request)
    {
        $response = $this->repo->verifyCode($request->input('user_id'), $request->input('code'));

        if(!empty($response))
        {
            $this->repo->updatePassword($response->id, $request->input('new_password'));
            $this->repo->updateCode($response->id, '');            
            return response()->json(['status' => 'success', 'message' => 'Password updated successfully', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Old password is not correct', 'code' => 404], 404);
        }
    }

    public function updatePassword(UserRequest $request)
    {
        $userId = \Session::get('user')['id'];
        $response = $this->repo->verifyPassword($userId, $request->input('old_password'));

        if(!empty($response))
        {
            $this->repo->updatePassword($userId, $request->input('new_password'));
            return response()->json(['status' => 'success', 'message' => 'Password updated successfully', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Old password is not correct', 'code' => 404], 404);
        }
    }

    public function resetPasswordEmail(UserRequest $request)
    {
        $response = $this->repo->resetPasswordEmail($request->input('email'));
        if(!empty($response))
        {
            return response()->json(['status' => 'success', 'message' => 'Check your email for password reset instruction', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'user not found', 'code' => 404], 404);
        }
    }

    public function destroy($id)
    {
        $response = $this->repo->destroy($id);
        if(!empty($response))
        {
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'user not found', 'code' => 404], 404);
        }
    }

    public function logout()
    {
        \Session::forget('user');
        $url = \URL::to('admin/');
        return redirect($url);
    }

    public function get($id)
    {
        $userData = $this->repo->get($id, false);
        if(!empty($userData))
        {
            return response()->json(['status' => 'success', 'message' => '', 'data' => $userData, 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'user not found', 'code' => 404], 404);            
        }
    }

}
