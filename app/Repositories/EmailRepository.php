<?php

namespace App\Repositories;

use App\Models\Email;
use App\Library\Utility;


class EmailRepository
{

    const CACHE = 'email-';
    public function update($id, $request)
    {

        $email = Email::find($id);
        if (!empty($email))
        {
            $email->template_name = $request->input('template_name');
            $email->subject = $request->input('subject');
            $email->template = $request->input('template');
            $email->status = $request->input('status');
        }
        else
        {
            return false;
        }


        if($email->update())
        {
            // clear cache
            $this->clearCache($email->id);
            return $email->id;
        }
        else
        {
            return false;
        }
    }

    public function verifyCode($code)
    {
        
    }

    public function save($request)
    {
        $email = new Email();
        $email->template_name = $request->input('template_name');
        $email->subject = $request->input('subject');
        $email->template = $request->input('template');
        $email->status = $request->input('status');
        if($email->save())
        {
            return $email->id;
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
            $emails = Email::paginate($limit);
        }
        else
        {
            $emails = Email::where('id', '>', '0')->get();
        }

        if(!empty($emails))
        {
            foreach ($emails as $key => $email) 
            {
                $response['data'][] = $this->get($email->id, false);
            }
        }

        if(!empty($limit))
            $response = Utility::paginator($response, $emails, $limit);

        return $response;

    }

    public function destroy($id)
    {
        $email = $this->get($id, true);
        if(!empty($email))
        {
            $email->delete();

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
            return Email::find($id);
        }

        $cachedData = \Cache::has($cacheKey);
        if(empty($cachedData))
        {
            $email = Email::find($id);

            if(!empty($email))
            {
                $email = $email->toArray();

                $email['updated_at'] = date('Y-m-d', strtotime($email['updated_at']));

                $email['created_at_formatted'] = date('Y-m-d', strtotime($email['created_at']));
                $email['updated_at_formatted'] = date('Y-m-d', strtotime($email['updated_at']));                

               // unset($country['password']);
                //unset($country['code']);

                // Set data in cache
                \Cache::forever($cacheKey, $email);

                return $email;
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
