<?php

namespace App\Core;

Class Configuration	{

    /**
     * @return array
     */
	public static function get(): array
    {
        /**
         * GENERAL
         */
        $config["PORT"] = 80;
        
        /**
         * PATH
         */
        $config["PATH_HOME"]        = "C:/laragon/";
        $config["PATH_FILES"]       = $config["PATH_HOME"] . "files/afpaconnect/HTML/";
        $config["PATH_SQL"]         = $config["PATH_HOME"] . "files/afpaconnect/SQL/";
        $config["PATH_CLASS"]       = $config["PATH_HOME"] . "modules/afpaconnect/";
        $config["PATH_CORE"]        = $config["PATH_CLASS"] . "core/";
        $config["PATH_UPLOAD"]      = $config["PATH_HOME"] . "www/afpaconnect/upload/";
        $config["BASE_HREF"]        = "/afpaconnect/";
        $config["PATH_MIGRATIONS"]  = "BDD/migrations/";
        $config["PATH_FIXTURES"]    = "BDD/fixtures/";

        /**
         * DATABASE
         */
        $config["db_hostname"] = "localhost";
        $config["db_username"] = "root";
        $config["db_password"] = "";
        $config["db_name"] = "afpaconnect";

        /**
         * GOOGLE RECAPTCHA
         */
        $config["captcha_secret"] = "6Lf9RtcZAAAAAEUQUscEcS-Cr0chxdnhxZMKteSG";
        $config["captcha_public"] = "";

        /**
         * EMAIL
         */
        $config["email_from"] = "afpaticket.afpalab@afpa.fr";
        $config["email_bcc"] = "jean-jacques.pagan@afpa.fr";

        return $config;
    }
}
