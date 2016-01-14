<?php

namespace App\Repositories;

use App\Models\VehicleType;
use App\Library\Utility;


class VehicleTypeRepository
{

    const CACHE = 'vehicle_type-';
    public function update($id, $request)
    {
        $vehicle_type = VehicleType::find($id);
        
        if (!empty($vehicle_type))
        {
            $vehicle_type->vehicle_type = $request->input('vehicle_type');
            $vehicle_type->pic_path = $request->input('pic_path');
            $vehicle_type->category_id = $request->input('category_id');
            $vehicle_type->status = $request->input('status');            
        }
        else
        {
            return false;
        }
       

        if($vehicle_type->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($vehicle_type->id);
            return $vehicle_type->id;
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
        $vehicle_type = new VehicleType();
        $vehicle_type->vehicle_type = $request->input('vehicle_type');
        $vehicle_type->pic_path = $request->input('pic_path');
        $vehicle_type->category_id = $request->input('category_id');
        $vehicle_type->status = $request->input('status');

        if($vehicle_type->save())
        {
            return $vehicle_type->id;
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
            $vehicle_types = VehicleType::paginate($limit);
        }
        else
        {
            $vehicle_types = VehicleType::where('id', '>', '0')->get();
        }

        if(!empty($vehicle_types))
        {
            foreach ($vehicle_types as $key => $vehicle_type) 
            {
                $response['data'][] = $this->get($vehicle_type->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $vehicle_types, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $vehicle_type = $this->get($id, true);
        if(!empty($vehicle_type))
        {
            $vehicle_type->delete();

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
        $catRepo = new VehicleCategoryRepository();

        $cacheKey = self::CACHE . $id;

        if($elequent)
        {
            return VehicleType::find($id);
        }

        $cachedData = \Cache::has($cacheKey);

        if(empty($cachedData))
        {
            $vehicle_type = VehicleType::find($id);

            if(!empty($vehicle_type))
            {
                $vehicle_type = $vehicle_type->toArray();

                // get cat name
                $catData = $catRepo->get($vehicle_type['category_id'], false);
                if(!empty($catData))
                {
                    $vehicle_type['category'] = $catData['category'];
                }
                else
                    $vehicle_type['category'] = '';

                if(!empty($vehicle_type['pic_path']))
                    $vehicle_type['image'] = env('STORAGE_URL').'vehicle_type_images/'.$vehicle_type['pic_path'];
                else
                    $vehicle_type['image'] = '';                

                $vehicle_type['updated_at'] = date('Y-m-d', strtotime($vehicle_type['updated_at']));

                $vehicle_type['created_at_formatted'] = date('Y-m-d', strtotime($vehicle_type['created_at']));
                $vehicle_type['updated_at_formatted'] = date('Y-m-d', strtotime($vehicle_type['updated_at']));                

                // Set data in cache
                \Cache::forever($cacheKey, $vehicle_type);

                return $vehicle_type;
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
