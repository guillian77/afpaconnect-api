<?php


namespace App\Core;


use App\Utility\Response;
use Exception;

class Certificate
{
    const TYPE_PUBLIC   = 'public';

    const TYPE_PRIVATE  = 'private';

    public function getCertificate(string $name, string $type)
    {
        $certPath = STORAGE.'certs/'.$name.'_'.$type.'.key';

        if (!file_exists($certPath)) {
            Response::resp('Certificate not found', 404, true);
        }

        return file_get_contents($certPath);
    }
}
