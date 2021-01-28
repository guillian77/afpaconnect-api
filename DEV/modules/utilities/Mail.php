<?php

class Mail {

    /**
     * Send a mail
     * 
     * @param String $to recipient
     * @param String $subject content of email
     * @param String $content
     */
    public static function send(String $to, String $subject, String $content):bool {

        $config = Configuration::getGlobalsINI();

        // Decode UTF-8 to iso-8859-1
        $subject = utf8_decode($subject);
        $from = utf8_decode($config["MAIL_FROM"]);
        $content = utf8_decode($content);
        $header = "From: $from\r\nContent-Type: text/html; charset=\"iso-8859-1\"\r\nBcc: " . $config["MAIL_BCC"] . "\r\n";

        if ($config['plateform'] === "local") {
            return true;
        }

		// send the mail
		return mail($to, $subject, $content, $header);
    }
}