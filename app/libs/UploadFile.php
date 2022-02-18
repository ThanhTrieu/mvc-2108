<?php

namespace app\libs;

class UploadFile
{
    public static function deleteFileServer($file, $path)
    {
        if(file_exists($path.$file)) {
            // ton tai file trong duong dan tren server
            unlink($path.$file);
        }
        return false;
    }

    public static function uploadFileToServer($file, $path, $conditions = [])
    {
        if(empty($file) || empty($path)){
            return false;
        }

        $nameFile = $file['name'];
        $tmpFile  = $file['tmp_name'];
        $error    = $file['error'];
        if($error === 0 && !empty($tmpFile)){
            // tien hanh upload
            if(move_uploaded_file($tmpFile, $path . $nameFile)){
                return $nameFile;
            }
            return false;
        }
        return false;
    }
}