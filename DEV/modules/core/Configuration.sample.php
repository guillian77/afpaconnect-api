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
        $config["DEV"]  = "__DEV__";
        $config["PORT"] = "__PORT__";

        /**
         * PATH
         */
        $config["PATH_HOME"]        = "__SRV_ROOT__";
        $config["PATH_FILES"]       = $config["PATH_HOME"] . "files/afpaconnect/HTML/";
        $config["PATH_SQL"]         = $config["PATH_HOME"] . "files/afpaconnect/SQL/";
        $config["PATH_SSL"]         = $config["PATH_HOME"] . "files/afpaconnect/SSL/";
        $config["PATH_CLASS"]       = $config["PATH_HOME"] . "modules/afpaconnect/";
        $config["PATH_CORE"]        = $config["PATH_CLASS"] . "core/";
        $config["PATH_UPLOAD"]      = $config["PATH_HOME"] . "__WEB_ROOT__/afpaconnect/upload/";
        $config["BASE_HREF"]        = "/afpaconnect/";
        $config["PATH_MIGRATIONS"]  = "BDD/migrations/";
        $config["PATH_FIXTURES"]    = "BDD/fixtures/";

        /**
         * DATABASE
         */
        $config["db_hostname"] = "__DB_HOSTNAME__";
        $config["db_username"] = "__DB_USERNAME__";
        $config["db_password"] = "__DB_PASSWORD__";
        $config["db_name"] = "__DB_NAME__";

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
