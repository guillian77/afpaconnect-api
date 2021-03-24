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

/* layout.php */
class __TwigTemplate_0aa15a4be915a36faf4b22d7d1b5cffa56e4e3965428c619999d635d66a35cf9 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
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

            <p>";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 24, $this->source); })()), "generate", [0 => "home"], "method", false, false, false, 24), "html", null, true);
        echo "</p>

            <?php if(isset(\$_SESSION['user']['uid'])): ?>
                <nav id=\"navbar\" class=\"flex navbar\">
                    <ul>
                        <li><a href=\"";
        // line 29
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 29, $this->source); })()), "generate", [0 => "user.manage"], "method", false, false, false, 29), "html", null, true);
        echo "\">Gestion utilisateurs</a></li>
                        <li><a href=\"";
        // line 30
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 30, $this->source); })()), "generate", [0 => "user.upload"], "method", false, false, false, 30), "html", null, true);
        echo "\">Nouveaux utilisateurs</a></li>
                        <li><a href=\"";
        // line 31
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 31, $this->source); })()), "generate", [0 => "home"], "method", false, false, false, 31), "html", null, true);
        echo "\">Configuration</a></li>
                    </ul>
                </nav>

                <a class=\"btn\" href=\"";
        // line 35
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["path"]) || array_key_exists("path", $context) ? $context["path"] : (function () { throw new RuntimeError('Variable "path" does not exist.', 35, $this->source); })()), "generate", [0 => "user.logout"], "method", false, false, false, 35), "html", null, true);
        echo "\"><i class=\"fas fa-sign-out-alt\"></i> Déconnexion</a>
            <?php endif; ?>
        </header>

        <?= \$content; ?>

        <footer class=\" footer boxed\">
            <p>&copy; 2021  Developped by Aufrère Guillian & Campillo Lucas for AFPA</p>
        </footer>
    </div>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "layout.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 35,  84 => 31,  80 => 30,  76 => 29,  68 => 24,  58 => 17,  49 => 11,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout.php", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\ressources\\views\\layout.php");
    }
}
