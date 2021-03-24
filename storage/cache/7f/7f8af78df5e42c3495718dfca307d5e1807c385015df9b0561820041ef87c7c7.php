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

/* user/login.html.twig */
class __TwigTemplate_df0a62e55d25b3babb7b0ec16b76b466b309fbdf387d12cc720f3d5f5a283d5f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("layout.html.twig", "user/login.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    Connexion - ";
        $this->displayParentBlock("title", $context, $blocks);
        echo "
";
    }

    // line 7
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        echo "    <div class=\"boxed\">
        <h2>S'identifier</h2>

        <form action=\"\" method=\"POST\">

            <?php if(!empty(\$errors)): ?>
            <?php foreach(\$errors as \$error): ?>
            <div class=\"alert alert-warning\">
                <p><?= \$error; ?></p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <input class=\"form__field\" type=\"text\" name=\"identifier\" id=\"identifier\" placeholder=\"Numéro de matricule\" />
            <input class=\"form__field\" type=\"password\" name=\"password\" id=\"password\" placeholder=\"Mot de passe\" />
            <input class=\"form__field\" type=\"hidden\" name=\"submitted\" id=\"submitted\" />

            <button class=\"btn\" type=\"submit\">Se connecter</button>
        </form>
    </div>
";
    }

    public function getTemplateName()
    {
        return "user/login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 8,  58 => 7,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'layout.html.twig' %}

{% block title %}
    Connexion - {{ parent() }}
{% endblock %}

{% block content %}
    <div class=\"boxed\">
        <h2>S'identifier</h2>

        <form action=\"\" method=\"POST\">

            <?php if(!empty(\$errors)): ?>
            <?php foreach(\$errors as \$error): ?>
            <div class=\"alert alert-warning\">
                <p><?= \$error; ?></p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <input class=\"form__field\" type=\"text\" name=\"identifier\" id=\"identifier\" placeholder=\"Numéro de matricule\" />
            <input class=\"form__field\" type=\"password\" name=\"password\" id=\"password\" placeholder=\"Mot de passe\" />
            <input class=\"form__field\" type=\"hidden\" name=\"submitted\" id=\"submitted\" />

            <button class=\"btn\" type=\"submit\">Se connecter</button>
        </form>
    </div>
{% endblock %}
", "user/login.html.twig", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\views\\user\\login.html.twig");
    }
}
