<?php


namespace App\Controller;


class Controller
{
    /**
     * @param string $view
     * @param array $parameters
     */
    public function render(string $view, array $parameters = []): void
    {
        if (!empty($parameters)) {
            extract($parameters);
        }

        $view = trim($view, ".php");

        require ROOT."ressources/views/$view.php";
    }
}