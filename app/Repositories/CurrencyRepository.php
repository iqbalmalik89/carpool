<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Library\Utility;


class CurrencyRepository
{

    const CACHE = 'currency-';
    public function update($id, $request)
    {

        $currency = Currency::find($id);
        if (!empty($currency))
        {
            $currency->currency = $request->input('currency');
            $currency->symbol = $request->input('symbol');
            
        }
        else
        {
            return false;
        }
       

        if($currency->update())
        {
            // update user session
            //$this->updateUserSession($systemUser->id);

            // clear cache
            $this->clearCache($currency->id);
            return $currency->id;
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
        $currencies = new Currency();
        $currencies->currency = $request->input('currency');
        $currencies->symbol = $request->input('symbol');

        if($currencies->save())
        {
            return $currencies->id;
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
            $currencies = Currency::paginate($limit);
        }
        else
        {
            $currencies = Currency::where('id', '>', '0')->get();
        }

        if(!empty($currencies))
        {
            foreach ($currencies as $key => $currency) 
            {
                $response['data'][] = $this->get($currency->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $currencies, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $currency = $this->get($id, true);
        if(!empty($currency))
        {
            $currency->delete();

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
            return Currency::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $currency = Currency::find($id);

            if(!empty($currency))
            {
                $currency = $currency->toArray();
                // if(!empty($country['pic_path']))
                //     $country['profile_pic'] = env('STORAGE_URL').'app/user_images/'.$country['pic_path'];
                // else
                //     $country['profile_pic'] = '';

                $currency['updated_at'] = date('Y-m-d', strtotime($currency['updated_at']));

                $currency['created_at_formatted'] = date('Y-m-d', strtotime($currency['created_at']));
                $currency['updated_at_formatted'] = date('Y-m-d', strtotime($currency['updated_at']));                

               // unset($country['password']);
                //unset($country['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $currency);

                return $currency;
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
