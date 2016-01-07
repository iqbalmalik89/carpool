<?php

namespace App\Repositories;

use App\Models\VehicleCategory;
use App\Library\Utility;


class VehicleCategoryRepository
{

    const CACHE = 'vehicle_category-';
    public function update($id, $request)
    {

        $vehicle_category = VehicleCategory::find($id);
        if (!empty($vehicle_category))
        {
            $vehicle_category->category = $request->input('category');
            $vehicle_category->status = $request->input('status');            
        }
        else
        {
            return false;
        }
       

        if($vehicle_category->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($vehicle_category->id);
            return $vehicle_category->id;
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
        $vehicle_category = new VehicleCategory();
        $vehicle_category->category = $request->input('category');
        $vehicle_category->status = $request->input('status');

        if($vehicle_category->save())
        {
            return $vehicle_category->id;
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
            $vehicle_categories = VehicleCategory::paginate($limit);
        }
        else
        {
            $vehicle_categories = VehicleCategory::where('id', '>', '0')->get();
        }

        if(!empty($vehicle_categories))
        {
            foreach ($vehicle_categories as $key => $vehicle_category) 
            {
                $response['data'][] = $this->get($vehicle_category->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $vehicle_categories, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $vehicle_category = $this->get($id, true);
        if(!empty($vehicle_category))
        {
            $vehicle_category->delete();

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
            return VehicleCategory::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $vehicle_category = VehicleCategory::find($id);

            if(!empty($vehicle_category))
            {
                $vehicle_category = $vehicle_category->toArray();
                

                $vehicle_category['updated_at'] = date('Y-m-d', strtotime($vehicle_category['updated_at']));

                $vehicle_category['created_at_formatted'] = date('Y-m-d', strtotime($vehicle_category['created_at']));
                $vehicle_category['updated_at_formatted'] = date('Y-m-d', strtotime($vehicle_category['updated_at']));                

                // Set data in cache
                \Cache::forever($cacheKey, $vehicle_category);

                return $vehicle_category;
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
