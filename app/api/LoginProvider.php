<?php

namespace App\Api;

use App\Core\App;
use App\Core\Request;
use App\Utility\Response;
use App\Utility\StatusCode;
use DI\DependencyException;
use DI\NotFoundException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LoginProvider
{
    /**
     * Provide a preformatted HTML/Javascript template to be used by external apps.
     *
     * @throws SyntaxError
     * @throws NotFoundException
     * @throws RuntimeError
     * @throws LoaderError
     * @throws DependencyException
     */
    public function loginFormProvider(Request $request, Response $response): void
    {
        /*
         * Get configuration from request.
         */
        $configuration = $request->query()->get('config');

        if (!$configuration) {
            $response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setStatusMessage("Missing parameter: config.")
                ->send(200, true);
        }

        // Load Twig.
        $twig = App::get()
            ->getContainer()
            ->get(Environment::class);

        // Get libs and javascript.
        $axios = file_get_contents(WWW.'libs/axios.min.js');
        $javascript = file_get_contents(WWW.'js/features/auth-form.js');

        // Preload twig template.
        $tpl = $twig->render('provider/auth.html.twig', [
            'axios' => $axios,
            'javascript' => $javascript,
            'configuration' => $configuration
        ]);

        // Display template.
        echo $tpl;
    }
}