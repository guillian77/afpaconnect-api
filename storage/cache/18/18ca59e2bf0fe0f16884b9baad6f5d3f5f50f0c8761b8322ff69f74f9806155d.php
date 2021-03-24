<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* layout.html.twig */
class __TwigTemplate_9df929d3f18772e57c0aeea5be091919223b30e39fa8d64dc9522f67f02d0e52 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'css' => [$this, 'block_css'],
            'content' => [$this, 'block_content'],
            'javascript' => [$this, 'block_javascript'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\" />

    <meta name=\"viewport\"
          content=\"width=device-width,
          user-scalable=no,
          initial-scale=1.0,
          maximum-scale=1.0,
          minimum-scale=1.0\">

    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">

    <!-- WEBSITE: Title -->
    <title>";
        // line 16
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

    <!-- WEBSITE: STYLES -->
    ";
        // line 19
        $this->displayBlock('css', $context, $blocks);
        // line 23
        echo "</head>
<body>
    <div class=\"container\">
        <header class=\"header boxed\">
            <div class=\"flex topheader\">
                <h1><a class=\"header__title\" href=\"";
        // line 28
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 28, $this->source); })()), "generate", [0 => "home"], "method", false, false, false, 28), "html", null, true);
        echo "\" title=\"Aller sur l'accueil\">AfpaConnect</a></h1>
                <!-- Hamburger Icon for responsive Menu -->
                <a href=\"javascript:void(0);\" class=\"icon\" onclick=\"mobileMenuHeader()\">
                    <i id=\"menuIcon\" class=\"fa fa-bars\"></i>
                </a>
            </div>

            ";
        // line 35
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "array", false, true, false, 35), "uid", [], "array", true, true, false, 35)) {
            // line 36
            echo "                <nav id=\"navbar\" class=\"flex navbar\">
                    <ul>
                        <li><a href=\"";
            // line 38
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 38, $this->source); })()), "generate", [0 => "user.manage"], "method", false, false, false, 38), "html", null, true);
            echo "\">Gestion utilisateurs</a></li>
                        <li><a href=\"";
            // line 39
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 39, $this->source); })()), "generate", [0 => "user.upload"], "method", false, false, false, 39), "html", null, true);
            echo "\">Nouveaux utilisateurs</a></li>
                        <li><a href=\"";
            // line 40
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 40, $this->source); })()), "generate", [0 => "home"], "method", false, false, false, 40), "html", null, true);
            echo "\">Configuration</a></li>
                    </ul>
                </nav>

                <a class=\"btn\" href=\"";
            // line 44
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 44, $this->source); })()), "generate", [0 => "user.logout"], "method", false, false, false, 44), "html", null, true);
            echo "\"><i class=\"fas fa-sign-out-alt\"></i> Déconnexion</a>
            ";
        }
        // line 46
        echo "        </header>

        ";
        // line 48
        $this->displayBlock('content', $context, $blocks);
        // line 51
        echo "
        <footer class=\" footer boxed\">
            <p>&copy; ";
        // line 53
        echo twig_escape_filter($this->env, (isset($context["copyright"]) || array_key_exists("copyright", $context) ? $context["copyright"] : (function () { throw new RuntimeError('Variable "copyright" does not exist.', 53, $this->source); })()), "html", null, true);
        echo "</p>
        </footer>
    </div>

    ";
        // line 57
        $this->displayBlock('javascript', $context, $blocks);
        // line 60
        echo "</body>
</html>";
    }

    // line 16
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, (isset($context["appTitle"]) || array_key_exists("appTitle", $context) ? $context["appTitle"] : (function () { throw new RuntimeError('Variable "appTitle" does not exist.', 16, $this->source); })()), "html", null, true);
    }

    // line 19
    public function block_css($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 20
        echo "        <link rel=\"stylesheet\" href=\"css/reset.css\" />
        <link rel=\"stylesheet\" href=\"css/app.css\" />
    ";
    }

    // line 48
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 49
        echo "
        ";
    }

    // line 57
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 58
        echo "        <script src=\"js/app.js\"></script>
    ";
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  163 => 58,  159 => 57,  154 => 49,  150 => 48,  144 => 20,  140 => 19,  133 => 16,  128 => 60,  126 => 57,  119 => 53,  115 => 51,  113 => 48,  109 => 46,  104 => 44,  97 => 40,  93 => 39,  89 => 38,  85 => 36,  83 => 35,  73 => 28,  66 => 23,  64 => 19,  58 => 16,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!doctype html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\" />

    <meta name=\"viewport\"
          content=\"width=device-width,
          user-scalable=no,
          initial-scale=1.0,
          maximum-scale=1.0,
          minimum-scale=1.0\">

    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">

    <!-- WEBSITE: Title -->
    <title>{% block title %}{{ appTitle }}{% endblock %}</title>

    <!-- WEBSITE: STYLES -->
    {% block css %}
        <link rel=\"stylesheet\" href=\"css/reset.css\" />
        <link rel=\"stylesheet\" href=\"css/app.css\" />
    {% endblock %}
</head>
<body>
    <div class=\"container\">
        <header class=\"header boxed\">
            <div class=\"flex topheader\">
                <h1><a class=\"header__title\" href=\"{{ path.generate('home') }}\" title=\"Aller sur l'accueil\">AfpaConnect</a></h1>
                <!-- Hamburger Icon for responsive Menu -->
                <a href=\"javascript:void(0);\" class=\"icon\" onclick=\"mobileMenuHeader()\">
                    <i id=\"menuIcon\" class=\"fa fa-bars\"></i>
                </a>
            </div>

            {% if session['user']['uid'] is defined  %}
                <nav id=\"navbar\" class=\"flex navbar\">
                    <ul>
                        <li><a href=\"{{ path.generate('user.manage') }}\">Gestion utilisateurs</a></li>
                        <li><a href=\"{{ path.generate('user.upload') }}\">Nouveaux utilisateurs</a></li>
                        <li><a href=\"{{ path.generate('home') }}\">Configuration</a></li>
                    </ul>
                </nav>

                <a class=\"btn\" href=\"{{ path.generate('user.logout') }}\"><i class=\"fas fa-sign-out-alt\"></i> Déconnexion</a>
            {% endif %}
        </header>

        {% block content %}

        {% endblock %}

        <footer class=\" footer boxed\">
            <p>&copy; {{ copyright }}</p>
        </footer>
    </div>

    {% block javascript %}
        <script src=\"js/app.js\"></script>
    {% endblock %}
</body>
</html>", "layout.html.twig", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\views\\layout.html.twig");
    }
}
