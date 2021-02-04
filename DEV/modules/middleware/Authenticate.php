<?php


namespace App\Middleware;


use function App\Core\dd;

class Authenticate
{
    public static function check($request)
    {
        $offlinePages = [
            "user_login"
        ];

        /**
         * Do not redirect user if is on offline allowed pages.
         */
        if (in_array($request->controller, $offlinePages))
        {
            return;
        }

        /**
         * Redirect user if not logged.
         */
        if (!self::isLogged())
        {
            header('Location: ' . $request->base . 'user_login');
        }
    }

    /**
     * Check if user is logged.
     *
     * @return bool
     */
    public static function isLogged()
    {
        if (isset($_SESSION['user']['uid']) && !empty($_SESSION['user']['uid']))
        {
            return true;
        }

        return false;
    }
}
