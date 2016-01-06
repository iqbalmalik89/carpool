<?php

namespace App\Repositories;

use App\Models\Radius;
use App\Library\Utility;


class RadiusRepository
{

    const CACHE = 'radius-';
    public function update($id, $request)
    {

        $radius = Radius::find($id);
        if (!empty($radius))
        {
            $radius->distance_from = $request->input('distance_from');
            $radius->distance_to = $request->input('distance_to');
            $radius->radius = $request->input('radius');
            
        }
        else
        {
            return false;
        }
       

        if($radius->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($radius->id);
            return $radius->id;
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
        $radius = new Radius();
        $radius->distance_from = $request->input('distance_from');
        $radius->distance_to = $request->input('distance_to');
        $radius->radius = $request->input('radius');

        if($radius->save())
        {
            return $radius->id;
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
            $radii = Radius::paginate($limit);
        }
        else
        {
            $radii = Radius::where('id', '>', '0')->get();
        }

        if(!empty($radii))
        {
            foreach ($radii as $key => $radius) 
            {
                $response['data'][] = $this->get($radius->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $radii, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $radius = $this->get($id, true);
        if(!empty($radius))
        {
            $radius->delete();

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
            return Radius::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $radius = Radius::find($id);

            if(!empty($radius))
            {
                $radius = $radius->toArray();
                // if(!empty($country['pic_path']))
                //     $country['profile_pic'] = env('STORAGE_URL').'app/user_images/'.$country['pic_path'];
                // else
                //     $country['profile_pic'] = '';

                $radius['updated_at'] = date('Y-m-d', strtotime($radius['updated_at']));

                $radius['created_at_formatted'] = date('Y-m-d', strtotime($radius['created_at']));
                $radius['updated_at_formatted'] = date('Y-m-d', strtotime($radius['updated_at']));                

               // unset($country['password']);
                //unset($country['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $radius);

                return $radius;
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
