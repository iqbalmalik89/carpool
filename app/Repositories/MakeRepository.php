<?php

namespace App\Repositories;

use App\Models\CarMake;
use App\Library\Utility;


class MakeRepository
{

   public function update($request)
   {
        $systemUser = SystemUser::find($request->input('user_id'));
        $systemUser->first_name = $request->input('first_name');
        $systemUser->last_name = $request->input('last_name');
        $systemUser->mobile = $request->input('mobile');
        $systemUser->email = $request->input('email');
        $systemUser->pic_path = $request->input('image_path');
        $systemUser->password = \Hash::make($request->input('password'));
        $systemUser->status = $request->input('status');
        if($systemUser->update())
        {
            return $systemUser->id;
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

   public function logout()
   {
    
   }

   public function listing($page, $limit)
   {
        $response = array('data' => array(), 'paginator' => '');
        if(!empty($limit))
        {
            $users = CarMake::paginate($limit);
        }
        else
        {
            $users = CarMake::where('id', '>', '0')->get();
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
            return true;
        }
        else
        {
            return false;
        }
    }

   public function login($request)
   {
        $response = SystemUser::where('email', $request['email'])
                                ->where('status', 'active')
                                ->first();
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
        $systemUser = SystemUser::find($id);

        if(!empty($systemUser))
        {
            if($elequent)
            {
                return $systemUser;
            }
            else
            {
                $systemUser = $systemUser->toArray();
                if(!empty($systemUser['pic_path']))
                    $systemUser['profile_pic'] = env('STORAGE_URL').'app/user_images/'.$systemUser['pic_path'];
                else
                    $systemUser['profile_pic'] = '';

                $systemUser['created_at_formatted'] = date('Y-m-d', strtotime($systemUser['created_at']));

                unset($systemUser['password']);
                unset($systemUser['code']);                
                return $systemUser;
            }
        }
        else
        {
            return false;
        }
    }

    public function setUserSession($systemUserData)
    {
        \Session::put('user', $systemUserData);
    }
}
