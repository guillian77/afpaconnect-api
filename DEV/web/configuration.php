<?php

Class Configuration	{
//	public static function getGlobalsINI()
//	{

//		// Check if document root exist
//		if ( empty($_SERVER['DOCUMENT_ROOT']) )
//		{
//			// PHP is called in command line interface (CLI, cron, etc ...).
//			// No document can exist
//			$DOCUMENT_ROOT = exec('cd ~ && pwd') . "/";
//		}
//		else
//		{
//			// PHP is called by a browser, DR exist.
//			$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
//		}
//
//		$aOfPaths= explode("/", $DOCUMENT_ROOT);
//
//		for ($i=count($aOfPaths)-1; $i>0; $i--)
//		{
//			$DOCUMENT_ROOT= str_replace($aOfPaths[$i], "", $DOCUMENT_ROOT);
//			$DOCUMENT_ROOT= str_replace("//", "/", $DOCUMENT_ROOT);
//
//			if (is_file($DOCUMENT_ROOT . "files/config_afpaconnect_dev.ini"))
//			{
//				return parse_ini_file($DOCUMENT_ROOT . "files/config_afpaconnect_dev.ini", false);
//			}
//			else if (is_file($DOCUMENT_ROOT . "files/config_afpaconnect_prod.ini"))
//			{
//				return parse_ini_file($DOCUMENT_ROOT . "files/config_afpaconnect_prod.ini", false);
//			}
//		}
//	}

	public static function getGlobalsINI()
    {
        return [

            /**
             * ------------------------
             * PATH
             * ------------------------
             */
            "path" => [
                "HOME" => "C:/laragon/",
                "FILES" => "files/afpaconnect/HTML/",
                "SQL" => "files/afpaconnect/SQL/",
                "CLASS" => "modules/afpaconnect/",
                "BASE_HREF" => "/afpaconnect/",

                "MIGRATIONS" => "BDD/migrations"
            ],

            /**
             * ------------------------
             * DATABASE CONNEXION
             * ------------------------
             */
            "db" => [
                "hostname" => "localhost",
                "username" => "root",
                "password" => "",
                "dbname" => "afpaconnect"
            ],

            /**
             * ------------------------
             * GOOGLE RECAPTCHA
             * ------------------------
             */
            "captcha" => [
                "SECRET" => "6Lf9RtcZAAAAAEUQUscEcS-Cr0chxdnhxZMKteSG",
                "PUBlIC" => ""
            ],

            /**
             * ------------------------
             * EMAIL
             * ------------------------
             */
            "mail" => [
                "FROM" => "afpaticket.afpalab@afpa.fr",
                "BCC" => "jean-jacques.pagan@afpa.fr"
            ]
        ];
    }
}