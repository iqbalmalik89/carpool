<?php

namespace App\Repositories;

use App\Models\Subscriber;
use App\Library\Utility;


class SubscriberRepository
{

    const CACHE = 'subscriber-';
    public function update($id, $request)
    {

        $subscriber = Subscriber::find($id);
        if (!empty($subscriber))
        {
            $subscriber->email = $request->input('email');
            $subscriber->ip = $request->input('ip');
        }
        else
        {
            return false;
        }
        // if(!empty($request->input('password')))
        //     $systemUser->password = \Hash::make($request->input('password'));

       // $country->status = $request->input('status', 'active');


        if($subscriber->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($subscriber->id);
            return $subscriber->id;
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
        $subscriber = new Subscriber();
        $subscriber->email = $request->input('email');
        $subscriber->ip = $request->input('ip');

        if($subscriber->save())
        {
            return $subscriber->id;
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
            $subscribers = Subscriber::paginate($limit);
        }
        else
        {
            $subscribers = Subscriber::where('id', '>', '0')->get();
        }

        if(!empty($subscribers))
        {
            foreach ($subscribers as $key => $subscriber) 
            {
                $response['data'][] = $this->get($subscriber->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $subscribers, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $subscriber = $this->get($id, true);
        if(!empty($subscriber))
        {
            $subscriber->delete();

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
            return Subscriber::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $subscriber = Subscriber::find($id);

            if(!empty($subscriber))
            {
                $subscriber = $subscriber->toArray();

                $subscriber['updated_at'] = date('Y-m-d', strtotime($subscriber['updated_at']));

                $subscriber['created_at_formatted'] = date('Y-m-d', strtotime($subscriber['created_at']));
                $subscriber['updated_at_formatted'] = date('Y-m-d', strtotime($subscriber['updated_at']));                

                // Set data in cache
                \Cache::forever($cacheKey, $subscriber);

                return $subscriber;
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
