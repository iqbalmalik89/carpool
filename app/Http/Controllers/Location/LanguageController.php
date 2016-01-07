<?php

namespace App\Http\Controllers\Location;

use App\Repositories\LanguageRepository;
use App\Http\Requests\LanguageRequest;
use App\Library\Uploader;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class LanguageController extends Controller
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
    public function __construct(LanguageRepository $systemRepo)
    {
        $this->repo = $systemRepo;
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
            'language' => 'required',
            'code' => 'required',
        ]);
    }


    public function verifyCode($code)
    {
        $resp = $this->repo->verifyCode($code);
        die();
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Language created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Language not registered successfully.', 'code' => 400], 400);
        }
    }

    public function save(LanguageRequest $request)
    {
        $resp = $this->repo->save($request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Language created successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Language not registered successfully.', 'code' => 400], 400);
        }
    }

    public function update(LanguageRequest $request, $id)
    {
        $resp = $this->repo->update($id, $request);
        if($resp)
        {
            return response()->json(['status' => 'success', 'message' => 'Language updated successfully', 'code' => 200], 200);            
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Language not updated successfully.', 'code' => 400], 400);
        }
    }

    public function listing(LanguageRequest $request)
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
            return response()->json(['status' => 'success', 'message' => 'Language deleted successfully', 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Language not found', 'code' => 404], 404);
        }
    }

    public function get($id)
    {
        $languageData = $this->repo->get($id, false);
        if(!empty($languageData))
        {
            return response()->json(['status' => 'success', 'message' => '', 'data' => $languageData, 'code' => 200], 200);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => 'Language not found', 'code' => 404], 404);            
        }
    }

}
