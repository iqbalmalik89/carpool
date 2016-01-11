<?php

namespace App\Library;

class Uploader
{
    public $imageExtensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');
    public $size = array('width' => '0', 'height' => '0' );
    public $directory = '';
    public function uploadImage($file)
    {
    	$response = array('status' => 'error', 'code' => '', 'file_type' => 'image');
    	$fileExt = strtolower($file->getClientOriginalExtension());
    	$fileName = md5(time()).'.'.$fileExt;
    	$destinationPath = env('STORAGE_PATH').DIRECTORY_SEPARATOR.$this->directory.DIRECTORY_SEPARATOR.$fileName;
    	$webUrl = env('STORAGE_URL').'app/'.$this->directory.'/'.$fileName;

    	if($this->checkExtension($fileExt, $this->imageExtensions))
    	{
    		$img = \Image::make( $file->getRealPath());

    		// Crop Image
    		if(!empty($this->size['width']) && !empty($this->size['height']))
    		{
	    		$img->fit($this->size['width'], $this->size['height']);
    		}

			$img->save($destinationPath )->destroy();
			$response = array('status' => 'success',
							  'code' => 'ok',
							  'path' => $fileName,
							  'web_url' => $webUrl, 
							  'file_type' => 'image',
							 );

    	}
    	else
    	{
    		$response['code'] = 'extension_error';
    	}

    	return $response;
    }
    
    public function checkExtension($fileExt, $extensions)
    {
    	if(in_array($fileExt, $extensions))
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
}
