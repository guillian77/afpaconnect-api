<?php

/*
|--------------------------------------------------------------------------
| Twig extensions
|--------------------------------------------------------------------------
|
| Here is registered Twig extensions available in any twig templates.
|
*/
return [
    \Twig\Extension\DebugExtension::class,
    \App\Core\TwigExtension\RouterExtension::class,
    \App\Core\TwigExtension\SessionExtension::class,
    \App\Core\TwigExtension\ConfigExtension::class,
];