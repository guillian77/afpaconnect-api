<?php


namespace App\Core;


class Controller
{
    /**
     * @var Request $request The request object.
     */
    public $request;

    /**
     * @var array $config Configurations
     */
    public $config;

    const FILETYPE_CSS = "css";
    const FILETYPE_JS = "js";

    public function __construct()
    {
        $this->request = new Request();
        $this->config = (App::getInstance())->configuration();
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

        // Define path of the view asked.
        $viewPath = $this->config['PATH_FILES'] . $name . ".html";

        /**
         * CATCHING THE VIEW
         */
        ob_start();

        if ( file_exists($viewPath) )
        {
            require $viewPath;
        }

        // Define theses variables to be used by the view.
        $content = ob_get_clean();
        $request = $this->request;
        $vue = $this;
        $config = $this->config;
        $javascript = $this->loadAssetFile($this->request->controller, self::FILETYPE_JS);
        $css = $this->loadAssetFile($this->request->controller, self::FILETYPE_CSS);
        $debug = "";
        if ($this->config['DEV']) {
            ob_start();
            require_once $this->config['PATH_FILES'] . "debug.html";
            $debug = ob_get_clean();
        }

        require_once $this->config['PATH_FILES'] . "layout.html";
    }

    /**
     * Format filename for CSS and Javascript files.
     *
     * Routes are loaded with classname (also controller name).
     *
     * The Classname is respect upper camel case syntax.
     *
     * So just split the controller name on upper letters.
     *
     * @param string $controllerName The controller name.
     * @param string $type           The asset file type.
     *
     * @return string Return path and type of asset file to load.
     */
    private function formatAssetFilename(string $controllerName, string $type):string
    {
        $split = preg_split('/(?=[A-Z])/', $controllerName, -1, PREG_SPLIT_NO_EMPTY);

        $path = $type . "/features/" . strtolower($split[0]) . "." . $type;

        if (isset($split[1])) {
            $path =  $type . "/features/" . strtolower($split[0]) . "_" . strtolower($split[1]) . "." . $type;
        }

        return $path;
    }

    /**
     * Buffer assets file call if file exist.
     *
     * @param string $controllerName
     * @param string $type
     *
     * @return false|string
     */
    private function loadAssetFile(string $controllerName, string $type)
    {
        $assetFilePath = $this->formatAssetFilename($controllerName, $type);

        if (!file_exists($assetFilePath)) {
            return false;
        }

        ob_start();

        if ($type === self::FILETYPE_CSS) {
            echo '<link rel="stylesheet" type="text/css" media="screen" href="'.$assetFilePath.'">';
        } elseif ($type === self::FILETYPE_JS) {
            echo '<script src="' . $assetFilePath . '"></script>';
        }

        return ob_get_clean();
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