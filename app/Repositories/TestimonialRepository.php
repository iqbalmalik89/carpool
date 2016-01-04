<?php

namespace App\Repositories;

use App\Models\Testimonial;
use App\Library\Utility;


class TestimonialRepository
{

    const CACHE = 'testimonial-';
    public function update($id, $request)
    {

        $testimonial = Testimonial::find($id);
        if (!empty($testimonial))
        {
            $testimonial->name = $request->input('name');
            $testimonial->description = $request->input('description');
            $testimonial->pic_path = $request->input('pic_path');
            $testimonial->status = $request->input('status');
            
        }
        else
        {
            return false;
        }
       

        if($testimonial->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($testimonial->id);
            return $testimonial->id;
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
        $testimonial = new Testimonial();
        $testimonial->name = $request->input('name');
        $testimonial->description = $request->input('description');
        $testimonial->pic_path = $request->input('pic_path');
        $testimonial->status = $request->input('status');
            

        if($testimonial->save())
        {
            return $testimonial->id;
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
            $testimonial = Testimonial::paginate($limit);
        }
        else
        {
            $testimonial = Testimonial::where('id', '>', '0')->get();
        }

        if(!empty($testimonial))
        {
            foreach ($testimonial as $key => $testimonials) 
            {
                $response['data'][] = $this->get($testimonials->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $testimonial, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $testimonial = $this->get($id, true);
        if(!empty($testimonial))
        {
            $testimonial->delete();

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
            return Testimonial::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $testimonial = Testimonial::find($id);

            if(!empty($testimonial))
            {
                $testimonial = $testimonial->toArray();
                if(!empty($testimonial['pic_path']))
                    $testimonial['image'] = env('STORAGE_URL').'app/testimonial_images/'.$testimonial['pic_path'];
                else
                    $testimonial['image'] = '';

                $testimonial['updated_at'] = date('Y-m-d', strtotime($testimonial['updated_at']));

                $testimonial['created_at_formatted'] = date('Y-m-d', strtotime($testimonial['created_at']));
                $testimonial['updated_at_formatted'] = date('Y-m-d', strtotime($testimonial['updated_at']));                

               // unset($country['password']);
                //unset($country['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $testimonial);

                return $testimonial;
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
