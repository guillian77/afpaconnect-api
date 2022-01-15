<?php

namespace App\Core\TwigExtension;

use App\Core\Conf;
use Twig\Error\Error;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Aufrère Guillian
 * @ConfigExtension
 */
class ConfigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getConfig', [$this, 'getConfigurationParameter'])
        ];
    }

    /**
     * Get a configuration parameter.
     *
     * @param string $parameter The configuration parameter name to get.
     *
     * @return void Configuration parameter.
     *
     * @throws Error
     */
    public function getConfigurationParameter(string $parameter)
    {
        $confParameter = Conf::get($parameter);

        if (!$confParameter) {
            throw new Error("No parameter $parameter in configuration.");
        }

        return $confParameter;
    }
}