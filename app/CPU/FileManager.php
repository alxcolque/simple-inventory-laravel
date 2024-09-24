<?php

namespace App\CPU;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ImageKit\ImageKit;
use Intervention\Image\Facades\Image;

class FileManager
{
    public static function path($path){
        return pathinfo($path, PATHINFO_FILENAME);
    }

    public static function upload($file, $folder_path){
        if ($file != null) {

            $file_name = $file->getClientOriginalName();
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            try{
                $file->move(public_path($folder_path), $imageName);
                $result = url('/').'/'.$folder_path.'/'.$imageName;
                return $result;
            }catch (\Exception $e) {
                //return "Error: ".$e->getMessage();
                return "Error33";
            }

        } else {
            $imageName = 'def.png';
        }
    }

    public static function replace($path, $image, $public_id, $folder_path){
        self::delete($path, $folder_path);
        return self::upload($image, $public_id, $folder_path);
    }

    public static function delete($path_url, $file_id){

        $host = url('/');
        $pathFile = substr($path_url, strlen($host)+1, strlen($path_url));
        if(File::exists(public_path($pathFile))){
            File::delete(public_path($pathFile));
            return "ok";
        }
        return "falla";

    }
}
