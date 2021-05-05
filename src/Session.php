<?php


namespace App\Core;

/**
 * Class Session
 * @package App\Core
 * @author Aufrère Guillian
 */
class Session
{
    /**
     * @param $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value): self
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function remove($key): self
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }

        return $this;
    }

    /**
     * @param $key
     * @return Session|bool|mixed
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            return false;
        }

        return $_SESSION[$key];
    }

    public function all(): array
    {
        return $_SESSION;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param $key
     * @return bool
     */
    public function contain($needle): bool
    {
        foreach ($_SESSION as $key => $session) {
            if (strstr($key, $needle)) {
                return true;
            }
        }

        return false;
    }
}
