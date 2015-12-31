<?php

namespace App\Repositories;

use App\Models\SystemUser;
use App\Library\Utility;


class SystemUserRepository
{

    const CACHE = 'system_users-';
    public function update($request)
    {
        echo $request;
        $systemUser = SystemUser::find($request->input('user_id'));
        $systemUser->first_name = $request->input('first_name');
        $systemUser->last_name = $request->input('last_name');
        $systemUser->mobile = $request->input('mobile');
        $systemUser->email = $request->input('email');
        $systemUser->pic_path = $request->input('image_path');
        if(!empty($request->input('password')))
            $systemUser->password = \Hash::make($request->input('password'));

        $systemUser->status = $request->input('status', 'active');


        if($systemUser->update())
        {
            // update user session
            $this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($systemUser->id);
            return $systemUser->id;
        }
        else
        {
            return false;
        }
    }

    public function getUserByCol($col, $value, $status)
    {
        $response = SystemUser::where($col, $value)
        ->where('status', $status)
        ->first();
        return $response;    
    }

    public function verifyCode($userId, $code)
    {
        $response = SystemUser::where('id', $userId)
        ->where('code', $code)
        ->where('status', 'active')
        ->first();
        return $response;
    }

    public function resetPasswordEmail($email)
    {
        $user = $this->getUserByCol('email', $email, 'active');
        if(!empty($user))
        {
            // send email to user
            $code = md5(time());
            $resetPasswordLink = \URL::to('admin/reset_password/'. $code);
            $param = array('subject' => 'Carpool - Reset Password',
                           'email' => $user->email,
                           'name' => $user->first_name.' '.$user->last_name,
                           'reset_link' => $resetPasswordLink,
                          );

            \Mail::send('admin.emails.reset_password', $param, function ($m) use ($param) {
                $m->from($param['email'], $param['subject']);
                $m->to($param['email'], $param['name'])->subject($param['subject']);
            });

            $this->updateCode($user->id, $code);

            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateCode($userId, $code)
    {
        $userData = $this->get($userId, true);
        if(!empty($userData))
        {
            $userData->code = $code;
            $userData->update();
            $this->clearCache($userId);
            return true;
        }
        else
        {
            return false;
        }
    }

    public function updateUserSession($userId)
    {
        if(\Session::has('user'))
        {
            if(\Session::get('user')['id'] == $userId)
            {
                $userData = $this->get($userId, false);
                $this->setUserSession($userData);
            }
        }
    }

    function updatePassword($userId, $password)
    {
        $userData = $this->get($userId, true);
        if(!empty($userData))
        {
            $userData->password = \Hash::make($password);
            $userData->update();
            return true;
        }
        else
        {
            return false;
        }
    }

    public function verifyPassword($userId, $oldPassword)
    {
        $userData = $this->get($userId, true);
        if(!empty($userData))
        {
            if (\Hash::check($oldPassword, $userData['password']))
            {
                return true;
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

    public function save($request)
    {
        $systemUser = new SystemUser();
        $systemUser->first_name = $request->input('first_name');
        $systemUser->last_name = $request->input('last_name');
        $systemUser->mobile = $request->input('mobile');
        $systemUser->email = $request->input('email');
        $systemUser->pic_path = $request->input('image_path');        
        $systemUser->password = \Hash::make($request->input('password'));
        $systemUser->status = $request->input('status');
        if($systemUser->save())
        {
            return $systemUser->id;
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
            $users = SystemUser::paginate($limit);
        }
        else
        {
            $users = SystemUser::where('id', '>', '0')->get();
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
            return SystemUser::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $systemUser = SystemUser::find($id);

            if(!empty($systemUser))
            {
                $systemUser = $systemUser->toArray();
                if(!empty($systemUser['pic_path']))
                    $systemUser['profile_pic'] = env('STORAGE_URL').'app/user_images/'.$systemUser['pic_path'];
                else
                    $systemUser['profile_pic'] = '';

                $systemUser['created_at_formatted'] = date('Y-m-d', strtotime($systemUser['created_at']));

                unset($systemUser['password']);
                unset($systemUser['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $systemUser);

                return $systemUser;
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

    public function setUserSession($systemUserData)
    {
        \Session::put('user', $systemUserData);
        \Session::save();
    }
}
