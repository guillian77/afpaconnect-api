<?php


namespace App\Core;


class Controller
{
    /**
     * @var Request $request The request object.
     */
    public $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * Render a view from views directory.
     *
     * @param string $name Name of the view file to render.
     * @param array|null $params Param come from FeatureController to pass to the view. Params should be compacted before.
     *
     * Exemple: $this->render('aView', compact(['varOne', 'varTwo']))
     */
    public function render(string $name, array $params = null)
    {
        // Extract parameters if exist
        if ($params)
        {
            extract($params);
        }

        // Get configuration for view path.
        $config = Configuration::get();

        // Define path of the view asked.
        $viewPath = $config['PATH_FILES'] . $name . ".html";

        // Start caching output.
        ob_start();
        // Check if view file exist.
        if ( file_exists($viewPath) )
        {
            require $viewPath;
        }

        // Put cache inside this variable.
        $content = ob_get_clean();

        require_once $config['PATH_FILES'] . "layout.html";
    }
}