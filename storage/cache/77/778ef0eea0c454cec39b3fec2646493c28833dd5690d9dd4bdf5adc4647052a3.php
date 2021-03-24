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
class __TwigTemplate_afae7616c10b4f306a61ff736f7f0ed2e7700f594923846f158efe20d8037a2d extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
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
          content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">

    <!-- WEBSITE: Title -->
<!--    <title>--><?//= \$appTitle; ?><!--</title>-->
    <title>";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["appTitle"]) || array_key_exists("appTitle", $context) ? $context["appTitle"] : (function () { throw new RuntimeError('Variable "appTitle" does not exist.', 11, $this->source); })()), "html", null, true);
        echo "</title>
</head>
<body>
    <div class=\"container\">
        <header class=\"header boxed\">
            <div class=\"flex topheader\">
                <h1><a class=\"header__title\" href=\"";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 17, $this->source); })()), "generate", [0 => "home"], "method", false, false, false, 17), "html", null, true);
        echo "\" title=\"Aller sur l'accueil\">AfpaConnect</a></h1>
                <!-- Hamburger Icon for responsive Menu -->
                <a href=\"javascript:void(0);\" class=\"icon\" onclick=\"mobileMenuHeader()\">
                    <i id=\"menuIcon\" class=\"fa fa-bars\"></i>
                </a>
            </div>

";
        // line 25
        echo "
";
        // line 27
        echo "
            ";
        // line 28
        echo twig_escape_filter($this->env, (isset($context["session"]) || array_key_exists("session", $context) ? $context["session"] : (function () { throw new RuntimeError('Variable "session" does not exist.', 28, $this->source); })()), "html", null, true);
        echo "
            <?php if(isset(\$_SESSION['user']['uid'])): ?>
                <nav id=\"navbar\" class=\"flex navbar\">
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
            <?php endif; ?>
        </header>

        ";
        // line 42
        $this->displayBlock('content', $context, $blocks);
        // line 45
        echo "
        <footer class=\" footer boxed\">
            <p>&copy; 2021  Developped by Aufrère Guillian & Campillo Lucas for AFPA</p>
        </footer>
    </div>
</body>
</html>";
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
        return array (  120 => 43,  116 => 42,  106 => 45,  104 => 42,  97 => 38,  90 => 34,  86 => 33,  82 => 32,  75 => 28,  72 => 27,  69 => 25,  59 => 17,  50 => 11,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout.html.twig", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\ressources\\views\\layout.html.twig");
    }
}
