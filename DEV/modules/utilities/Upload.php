<?php


class Upload
{
    
    /**
     * Parse XLS file and get content
     * 
     * @param mixed $tmp_name file's name
     * @param bool $save Upload XLS file
     * 
     * @return Array
     */
    public static function parse($tmp_name, bool $save = false){

        if($save){
            $uploads_dir = '/uploads';
            $config = Configuration::get();
            $name = basename($_FILES["upload_user"]["name"]);
            move_uploaded_file($tmp_name, $config["PATH_UPLOAD"].$name);
        }

        if ( $xlsx = SimpleXLSX::parse($tmp_name) ) {
            return $xlsx->rows();
        } else {
            return SimpleXLSX::parseError();
        }
    }
}