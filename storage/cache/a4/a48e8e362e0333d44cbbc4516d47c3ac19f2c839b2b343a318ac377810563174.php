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
class __TwigTemplate_067c2ff73fbbd225727379af70a911b9eddc900e9a71cafef767f595b308a027 extends Template
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
        echo twig_escape_filter($this->env, ($context["appTitle"] ?? null), "html", null, true);
        echo "</title>
</head>
<body>
    <div class=\"container\">
        <header class=\"header boxed\">
            <div class=\"flex topheader\">
                <h1><a class=\"header__title\" href=\"<?= \$router->generate('home'); ?>\" title=\"Aller sur l'accueil\">AfpaConnect</a></h1>
                <!-- Hamburger Icon for responsive Menu -->
                <a href=\"javascript:void(0);\" class=\"icon\" onclick=\"mobileMenuHeader()\">
                    <i id=\"menuIcon\" class=\"fa fa-bars\"></i>
                </a>
            </div>

            <?php if(isset(\$_SESSION['user']['uid'])): ?>
                <nav id=\"navbar\" class=\"flex navbar\">
                    <ul>
                        <li><a href=\"<?= \$router->generate('UserManage'); ?>\">Gestion utilisateurs</a></li>
                        <li><a href=\"<?= \$router->generate('UserUpload'); ?>\">Nouveaux utilisateurs</a></li>
                        <li><a href=\"<?= \$router->generate('home'); ?>\">Configuration</a></li>
                    </ul>
                </nav>

                <a class=\"btn\" href=\"<?= \$router->path('UserLogout'); ?>\"><i class=\"fas fa-sign-out-alt\"></i> Déconnexion</a>
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
        return array (  49 => 11,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout.php", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\ressources\\views\\layout.php");
    }
}
