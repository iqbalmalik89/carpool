<?php

namespace App\Repositories;

use App\Models\Country;
use App\Library\Utility;


class CountryRepository
{

    const CACHE = 'country-';
    public function update($id, $request)
    {

        $country = Country::find($id);
        if (!empty($country))
        {
            $country->country_name = $request->input('country_name');
            $country->country_code = $request->input('country_code');
            $country->currency = $request->input('currency');
            $country->status = $request->input('status');
        }
        else
        {
            return false;
        }
        // if(!empty($request->input('password')))
        //     $systemUser->password = \Hash::make($request->input('password'));

       // $country->status = $request->input('status', 'active');


        if($country->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($country->id);
            return $country->id;
        }
        else
        {
            return false;
        }
    }

    // public function getUserByCol($col, $value, $status)
    // {
    //     $response = SystemUser::where($col, $value)
    //     ->where('status', $status)
    //     ->first();
    //     return $response;    
    // }

    public function verifyCode($code)
    {
        
    }

    // public function updateCode($userId, $code)
    // {
    //     $userData = $this->get($userId, true);
    //     if(!empty($userData))
    //     {
    //         $userData->code = $code;
    //         $userData->update();
    //         $this->clearCache($userId);
    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    // public function updateUserSession($userId)
    // {
    //     if(\Session::has('user'))
    //     {
    //         if(\Session::get('user')['id'] == $userId)
    //         {
    //             $userData = $this->get($userId, false);
    //             $this->setUserSession($userData);
    //         }
    //     }
    // }

    public function save($request)
    {
        $country = new Country();
        $country->country_name = $request->input('country_name');
        $country->country_code = $request->input('country_code');
        $country->currency = $request->input('currency');
        $country->status = $request->input('status');
        if($country->save())
        {
            return $country->id;
        }
        else
        {
            return false;
        }
    }

    public function listing($page, $limit)
    {
        $response = array('data' => array(), 'paginator' => '');

        if(!empty($limit))
        {
            $countries = Country::paginate($limit);
        }
        else
        {
            $countries = Country::where('id', '>', '0')->get();
        }

        if(!empty($countries))
        {
            foreach ($countries as $key => $country) 
            {
                $response['data'][] = $this->get($country->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $countries, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $country = $this->get($id, true);
        if(!empty($country))
        {
            $country->delete();

            // clear cache
            $this->clearCache($id);

            return true;
        }
        else
        {
            return false;
        }
    }

    public function get($id, $elequent)
    {
        $cacheKey = self::CACHE . $id;

        if($elequent)
        {
            return Country::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $country = Country::find($id);

            if(!empty($country))
            {
                $country = $country->toArray();
                // if(!empty($country['pic_path']))
                //     $country['profile_pic'] = env('STORAGE_URL').'app/user_images/'.$country['pic_path'];
                // else
                //     $country['profile_pic'] = '';

                $country['updated_at'] = date('Y-m-d', strtotime($country['updated_at']));

                $country['created_at_formatted'] = date('Y-m-d', strtotime($country['created_at']));
                $country['updated_at_formatted'] = date('Y-m-d', strtotime($country['updated_at']));                

               // unset($country['password']);
                //unset($country['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $country);

                return $country;
            }
            else
            {
                return false;
            }            
        }
        else
        {
            return \Cache::get($cacheKey);
        }

    }

    public function clearCache($id)
    {
        $cacheKey = self::CACHE . $id;
        $cachedData = \Cache::forget($cacheKey);
    }

    // public function setUserSession($systemUserData)
    // {
    //     \Session::put('user', $systemUserData);
    //     \Session::save();
    // }
}
