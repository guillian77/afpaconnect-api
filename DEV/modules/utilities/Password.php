<?php

class Password {

    /**
     * Hash password with an algorithms (default: PASSWORD_ARGON2I)
     * 
     * @param String $password
     * @param Mixed algorithms
     * @return String hashed password
     * 
     * PASSWORD_DEFAULT
     * PASSWORD_BCRYPT
     * PASSWORD_ARGON2I
     * PASSWORD_ARGON2ID
     */
    public static function hash($password, $hash = PASSWORD_ARGON2I):string {
        return password_hash($password, $hash);
    }


    /**
     * Verify a password
     * 
     * @param String $password
     * @param String $password
     * @return Bool
     */
    public static function verify(String $password, String $hash):bool {
        return password_verify($password, $hash);
    }

    /**
     * Check password format
     * 
     * @param String $password
     */
    public static function isValide(String $password):bool {

        if (strlen($password < 8)) {
            return FALSE;
        }

        return true;
    }
}
