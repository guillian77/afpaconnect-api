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
class __TwigTemplate_945d27b8b5b92905b8314cec59e56238607b1445dcf0f59f48c940877f1da0d6 extends Template
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
            'content' => [$this, 'block_content'],
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
</head>
<body>
    <div class=\"container\">
        <header class=\"header boxed\">
            <div class=\"flex topheader\">
                <h1><a class=\"header__title\" href=\"";
        // line 22
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 22, $this->source); })()), "generate", [0 => "home"], "method", false, false, false, 22), "html", null, true);
        echo "\" title=\"Aller sur l'accueil\">AfpaConnect</a></h1>
                <!-- Hamburger Icon for responsive Menu -->
                <a href=\"javascript:void(0);\" class=\"icon\" onclick=\"mobileMenuHeader()\">
                    <i id=\"menuIcon\" class=\"fa fa-bars\"></i>
                </a>
            </div>

            ";
        // line 29
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "array", false, true, false, 29), "uid", [], "array", true, true, false, 29)) {
            // line 30
            echo "                <nav id=\"navbar\" class=\"flex navbar\">
                    <ul>
                        <li><a href=\"";
            // line 32
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 32, $this->source); })()), "generate", [0 => "user.manage"], "method", false, false, false, 32), "html", null, true);
            echo "\">Gestion utilisateurs</a></li>
                        <li><a href=\"";
            // line 33
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 33, $this->source); })()), "generate", [0 => "user.upload"], "method", false, false, false, 33), "html", null, true);
            echo "\">Nouveaux utilisateurs</a></li>
                        <li><a href=\"";
            // line 34
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 34, $this->source); })()), "generate", [0 => "home"], "method", false, false, false, 34), "html", null, true);
            echo "\">Configuration</a></li>
                    </ul>
                </nav>

                <a class=\"btn\" href=\"";
            // line 38
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 38, $this->source); })()), "generate", [0 => "user.logout"], "method", false, false, false, 38), "html", null, true);
            echo "\"><i class=\"fas fa-sign-out-alt\"></i> Déconnexion</a>
            ";
        }
        // line 40
        echo "        </header>

        ";
        // line 42
        $this->displayBlock('content', $context, $blocks);
        // line 45
        echo "
        <footer class=\" footer boxed\">
            <p>&copy; ";
        // line 47
        echo twig_escape_filter($this->env, (isset($context["copyright"]) || array_key_exists("copyright", $context) ? $context["copyright"] : (function () { throw new RuntimeError('Variable "copyright" does not exist.', 47, $this->source); })()), "html", null, true);
        echo "</p>
        </footer>
    </div>
</body>
</html>";
    }

    // line 16
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, (isset($context["appTitle"]) || array_key_exists("appTitle", $context) ? $context["appTitle"] : (function () { throw new RuntimeError('Variable "appTitle" does not exist.', 16, $this->source); })()), "html", null, true);
    }

    // line 42
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 43
        echo "
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
        return array (  131 => 43,  127 => 42,  120 => 16,  111 => 47,  107 => 45,  105 => 42,  101 => 40,  96 => 38,  89 => 34,  85 => 33,  81 => 32,  77 => 30,  75 => 29,  65 => 22,  56 => 16,  39 => 1,);
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
</body>
</html>", "layout.html.twig", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\ressources\\views\\layout.html.twig");
    }
}
