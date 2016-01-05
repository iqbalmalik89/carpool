<?php

namespace App\Repositories;

use App\Models\User;
use App\Library\Utility;


class UserRepository
{

    const CACHE = 'users-';
    public function update($request)
    {
        echo $request;
        $user = User::find($request->input('user_id'));
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->pic_path = $request->input('image_path');
        if(!empty($request->input('password')))
            $user->password = \Hash::make($request->input('password'));

        $user->status = $request->input('status', 'active');


        if($user->update())
        {
            // update user session
            // $this->updateUserSession($user->id);

            // clear cache
            $this->clearCache($user->id);
            return $user->id;
        }
        else
        {
            return false;
        }
    }

    public function getUserByCol($col, $value, $status)
    {
        $response = User::where($col, $value)
        ->where('status', $status)
        ->first();
        return $response;    
    }

    public function verifyCode($userId, $code)
    {
        $response = User::where('id', $userId)
        ->where('code', $code)
        ->where('status', 'active')
        ->first();
        return $response;
    }

    // public function resetPasswordEmail($email)
    // {
    //     $user = $this->getUserByCol('email', $email, 'active');
    //     if(!empty($user))
    //     {
    //         // send email to user
    //         $code = md5(time());
    //         $resetPasswordLink = \URL::to('admin/reset_password/'. $code);
    //         $param = array('subject' => 'Carpool - Reset Password',
    //                        'email' => $user->email,
    //                        'name' => $user->first_name.' '.$user->last_name,
    //                        'reset_link' => $resetPasswordLink,
    //                       );

    //         \Mail::send('admin.emails.reset_password', $param, function ($m) use ($param) {
    //             $m->from($param['email'], $param['subject']);
    //             $m->to($param['email'], $param['name'])->subject($param['subject']);
    //         });

    //         $this->updateCode($user->id, $code);

    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

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

    // function updatePassword($userId, $password)
    // {
    //     $userData = $this->get($userId, true);
    //     if(!empty($userData))
    //     {
    //         $userData->password = \Hash::make($password);
    //         $userData->update();
    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    // public function verifyPassword($userId, $oldPassword)
    // {
    //     $userData = $this->get($userId, true);
    //     if(!empty($userData))
    //     {
    //         if (\Hash::check($oldPassword, $userData['password']))
    //         {
    //             return true;
    //         }
    //         else
    //         {
    //             return false;                
    //         }
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    public function save($request)
    {
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->pic_path = $request->input('image_path');        
        $user->password = \Hash::make($request->input('password'));
        $user->status = $request->input('status');
        if($user->save())
        {
            return $user->id;
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
            $users = User::paginate($limit);
        }
        else
        {
            $users = User::where('id', '>', '0')->get();
        }

        if(!empty($users))
        {
            foreach ($users as $key => $user) 
            {
                $response['data'][] = $this->get($user->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $users, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $user = $this->get($id, true);
        if(!empty($user))
        {
            $user->delete();

            // clear cache
            $this->clearCache($id);

            return true;
        }
        else
        {
            return false;
        }
    }

    public function login($request)
    {
        $response = $this->getUserByCol('email', $request['email'], 'active');

        if ($response)
        {
            if (\Hash::check($request['password'], $response['password']))
            {
                if($response->status == 'inactive')
                {
                    return 'inactive';
                }
                else
                {
                    return $response->id;
                }
            }
            else
            {
                return false;
            }
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
            return User::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $user = User::find($id);

            if(!empty($user))
            {
                $user = $user->toArray();
                if(!empty($user['pic_path']))
                    $user['profile_pic'] = env('STORAGE_URL').'app/site_user_images/'.$user['pic_path'];
                else
                    $user['profile_pic'] = '';

                $user['created_at_formatted'] = date('Y-m-d', strtotime($user['created_at']));

                unset($user['password']);
                unset($user['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $user);

                return $user;
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
