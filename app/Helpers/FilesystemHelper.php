<?php

namespace App\Helpers;

use Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as IImage;

class FilesystemHelper {



    public static function uploadPhotoWithAllSizes($requestFile, $Folder,$uuid) { 
        $extension = $requestFile->getClientOriginalExtension(); // getting image extension 
        $watermark_url =    "images/Watermark.png";
        
        $url_fullsize = FilesystemHelper::uploadRequestFile($requestFile, $Folder,true);
        
        $img_thumbnail = IImage::make($requestFile/*$url_fullsize*/);
        if ($img_thumbnail->width() > 512)
        { 
            $img_thumbnail->resize(512, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $url_img_thumbnail =FilesystemHelper::uploadRequestFileStream($requestFile , $img_thumbnail->stream(),
        $Folder.'/thumb'); 



        $img_preview = IImage::make($requestFile);
        if ($img_preview->width() > 1024)
        { 
            $img_preview->resize(1024, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } 
        $watermark = IImage::make($watermark_url );
        if ($watermark->width() > $img_preview->width())
        {
            $watermark->resize($img_preview->width(), $img_preview->height());
        }
        $img_preview->insert($watermark, 'center');
        
        $url_preview =FilesystemHelper::uploadRequestFileStream($requestFile, $img_preview->stream(), 
        $Folder.'/preview'); 
        return [
            'url_fullsize' => $url_fullsize,
            'url_preview' => $url_preview, 
            'url_thumb' => $url_img_thumbnail , 
            'extension' => $extension
        ]; 
    }
    public static function uploadRequestFile($requestFile, $Folder,$private=false) {
 
        $extension = $requestFile->getClientOriginalExtension(); // getting image extension
        //$path = '/profile.' . $extension;
        //or 
         $filenamewithextension = $requestFile->getClientOriginalName();
        //get filename without extension
         $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
         $generated_filename = '/'. time().'_'.$filename.'.'.$extension;;

        $fullPath =$Folder . $generated_filename;
        $uploadedPath = self::saveFile_Stream(file_get_contents($requestFile), $fullPath,$private); 
        
        return $uploadedPath;
    }

    public static function uploadRequestFileStream($requestFile,$fileContent, $Folder,$private=false) {
        $extension = $requestFile->getClientOriginalExtension(); // getting image extension
        //$path = '/profile.' . $extension;
        //or 
         $filenamewithextension = $requestFile->getClientOriginalName();
        //get filename without extension
         $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
         $generated_filename = '/'. time().'_'.$filename.'.'.$extension;;

         $path =$Folder . $generated_filename;

        
        
        if ($private)
        {
            $bucket = Config::get('filesystems.disks.s3_private.bucket');
            $s3 = Storage::disk('s3_private');
            $saved = $s3->put($path, $fileContent, $s3::VISIBILITY_PRIVTE);
        }else
        {
            $bucket = Config::get('filesystems.disks.s3.bucket');
            $s3 = Storage::disk('s3');
            $saved = $s3->put($path, $fileContent, $s3::VISIBILITY_PUBLIC);
        }
        

        $fullPath = NULL;

        if ($saved)
            $fullPath = $s3->getAdapter()->getClient()->getObjectUrl($bucket , $path);

        return $fullPath;
    }
    public static function saveFile_Stream($fileContent, $path,$private=false) {

        if ($private)
        {
            $bucket = Config::get('filesystems.disks.s3_private.bucket');
            $s3 = Storage::disk('s3_private');
            $saved = $s3->put($path, $fileContent, $s3::VISIBILITY_PRIVATE);
        }else
        {
            $bucket = Config::get('filesystems.disks.s3.bucket');
            $s3 = Storage::disk('s3');
            $saved = $s3->put($path, $fileContent, $s3::VISIBILITY_PUBLIC);
        }
       

        $fullPath = NULL;

        if ($saved)
            $fullPath = $s3->getAdapter()->getClient()->getObjectUrl($bucket, $path);

        return $fullPath;
    }
    public static function saveFile_Content($fileContent, $path,$private=false) {

        if ($private)
        {
            $bucket = Config::get('filesystems.disks.s3_private.bucket');
            $s3 = Storage::disk('s3_private');
            $saved = $s3->put($path, $fileContent, $s3::VISIBILITY_PRIVTE);
        }else
        {
            $bucket = Config::get('filesystems.disks.s3.bucket');
            $s3 = Storage::disk('s3');
            $saved = $s3->put($path, $fileContent, $s3::VISIBILITY_PUBLIC);
        }
        $fullPath = NULL;

        if ($saved)
            $fullPath = $s3->getAdapter()->getClient()->getObjectUrl($bucket, $path);

        return $fullPath;
    }

    public static function saveBase64Image($bas64Image, $path) {

        $image = base64_decode($bas64Image);

        return self::saveFile_Content($image, $path);
    }

    public static function moveS3File($old_filePath, $filePath) {
        if (isset($old_filePath) && isset($filePath)) {
            $relativePath = explode(env('AMAZON_S3_BUCKET') . "/", $filePath);
            $old_relativePath = explode(env('AMAZON_S3_BUCKET') . "/", $old_filePath);


            if (count($relativePath) > 0) {
                $s3 = Storage::disk('s3');
                
                if ($s3->exists($old_relativePath[1])) {
                    if ($s3->exists($relativePath[1])) {
                       $s3->delete($relativePath[1]);
                    }
                    $s3->move($old_relativePath[1], $relativePath[1]);

                    $fullPath = $s3->getAdapter()->getClient()->getObjectUrl(Config::get('filesystems.disks.s3.bucket'), $relativePath[1]);

                     return $fullPath;
                }
            }
        }
        return '';
    }

    public static function removeFile($filePath,$private=false) {
        if (isset($filePath)) {
            $relativePath = explode(env('AMAZON_S3_BUCKET') . "/", $filePath);
            if (count($relativePath) > 0) {
                $s3 = Storage::disk('s3');
                if ($s3->exists($relativePath[1])) {
                    $s3->delete($relativePath[1]);
                }
                $fullPath = $s3->getAdapter()->getClient()->getObjectUrl(Config::get('filesystems.disks.s3.bucket'), $relativePath[1]);
                return $fullPath;
            }
        }
        return '';
    }

    public static function removeFile_fullpath($filePath,$private=false) {
         
        
        if (isset($filePath)) {
            $url = parse_url($filePath);
            if (isset($url['path']))
            {

                if ($private)
                {
                    $bucket = Config::get('filesystems.disks.s3_private.bucket');
                    $s3 = Storage::disk('s3_private'); 
                }else
                {
                    $bucket = Config::get('filesystems.disks.s3.bucket');
                    $s3 = Storage::disk('s3'); 
                }

                $path = $url['path'];   
                if ($s3->exists($path)) {
                    $s3->delete($path);
                    return true;
                }  
            } 
        }
        return false;
    }

}
