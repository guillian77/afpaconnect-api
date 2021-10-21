<?php

namespace App\Utility;

use App\Core\Conf;
use SimpleXLSX;

class Upload
{
    const FILE_TYPE_XML = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
    const FILE_TYPE_EXCEL = "application/vnd.ms-excel";

    /**
     * Parse XLS file and get content
     * 
     * @param mixed $tmp_name file's name
     *
     * @return array|false
     */
    public static function parse($tmp_name){
        $xlsx = SimpleXLSX::parse($tmp_name);

        return $xlsx ? $xlsx->rows() : SimpleXLSX::parseError();
    }
}