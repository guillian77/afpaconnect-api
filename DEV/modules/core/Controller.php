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

        $request = $this->request;
        $vue = $this;

        // Get configuration for view path.
        $config = Configuration::get();

        // Define path of the view asked.
        $viewPath = $config['PATH_FILES'] . $name . ".html";

        /**
         * CATCHING JAVASCRIPT
         * If there is a javascript file called like the controller name. Load it!
         */
        ob_start();

        $jsPath = "js/features/" . $this->request->controller . ".js";
        if ( file_exists($jsPath) )
        {
            echo '<script src="' . $jsPath . '"></script>';
        }
        $javascript = ob_get_clean();

        /**
         * CATCHING STYLE
         * If there is a css file called like the controller name. Load it!
         */
        ob_start();

        $cssPath = "css/features/" . $this->request->controller . ".css";
        if ( file_exists($cssPath) )
        {
            echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$cssPath.'">';
        }
        $css = ob_get_clean();

        /**
         * CATCHING THE VIEW
         */
        ob_start();

        if ( file_exists($viewPath) )
        {
            require $viewPath;
        }

        $content = ob_get_clean();

        require_once $config['PATH_FILES'] . "layout.html";
    }

    /**
     * Construct an URL from base URL.
     *
     * @param $target
     * @return string
     */
    public function path($target = null)
    {
        return $this->request->base . $target;
    }

    /**
     * Redirect user to a target URL.
     *
     * @param string $target Target URL to reach after redirection.
     */
    public function redirect(string $target)
    {
        $target = $this->request->base . $target;

        if ( headers_sent() )
        {
            echo '<meta http-equiv="refresh" content="durée;URL=' . $target . '">';
        } else{
            header('Location: ' . $target);
        }
    }
}