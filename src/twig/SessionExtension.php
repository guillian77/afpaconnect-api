<?php

namespace App\Core\TwigExtension;


use App\Core\Session;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SessionExtension
 * @package App\Core\TwigExtension
 * @author Aufrère Guillian
 */
class SessionExtension extends AbstractExtension
{
    /**
     * @var Session
     */
    private Session $session;

    /**
     * RouterExtension constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('session', [$this, 'getSession'])
        ];
    }

    /**
     * @param string $key
     * @return Session|bool|mixed
     */
    public function getSession(string $key)
    {
        return $this->session->get($key);
    }
}
