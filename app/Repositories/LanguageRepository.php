<?php

namespace App\Repositories;

use App\Models\Language;
use App\Library\Utility;


class LanguageRepository
{

    const CACHE = 'language-';
    public function update($id, $request)
    {

        $language = Language::find($id);
        if (!empty($language))
        {
            $language->language = $request->input('language');
            $language->code = $request->input('code');
            
        }
        else
        {
            return false;
        }
       

        if($language->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($language->id);
            return $language->id;
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
        //var_dump($request->input::all());
        $language = new Language();
        // $language->language = $request->input('language');
        // $language->symbol = $request->input('code');
        
        $language->language = 'English';
        $language->code = '01';

        if($language->save())
        {
            return $language->id;
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
            $languages = Language::paginate($limit);
        }
        else
        {
            $languages = Language::where('id', '>', '0')->get();
        }

        if(!empty($languages))
        {
            foreach ($languages as $key => $language) 
            {
                $response['data'][] = $this->get($language->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $languages, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $language = $this->get($id, true);
        if(!empty($language))
        {
            $language->delete();

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
            return Language::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $language = Language::find($id);

            if(!empty($language))
            {
                $language = $language->toArray();
                // if(!empty($country['pic_path']))
                //     $country['profile_pic'] = env('STORAGE_URL').'app/user_images/'.$country['pic_path'];
                // else
                //     $country['profile_pic'] = '';

                $language['updated_at'] = date('Y-m-d', strtotime($language['updated_at']));

                $language['created_at_formatted'] = date('Y-m-d', strtotime($language['created_at']));
                $language['updated_at_formatted'] = date('Y-m-d', strtotime($language['updated_at']));                

               // unset($country['password']);
                //unset($country['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $language);

                return $language;
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
