<?php

namespace App\Utility;

use App\Core\Conf;
use SimpleXLSX;

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

        
        if ( $xlsx = SimpleXLSX::parse($tmp_name) ) {
            return $xlsx->rows();
        } else {
            return SimpleXLSX::parseError();
        }
    }
}