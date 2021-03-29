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
     * @var array
     */
    private array $storage = [];

    /**
     * @param $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value): self
    {
        $this->storage[$key] = $value;

        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function remove($key): self
    {
        if ($this->has($key)) {
            unset($this->storage[$key]);
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

        return $this->storage[$key];
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return isset($this->storage[$key]);
    }
}
