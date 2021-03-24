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

/* user/manage.html.twig */
class __TwigTemplate_c737784eb675e689af3dfb7b5d45c70f3295ab65c54ce2fa1b8d915aec289619 extends Template
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
        $this->parent = $this->loadTemplate("layout.html.twig", "user/manage.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    Récapitulatif - ";
        $this->displayParentBlock("title", $context, $blocks);
        echo "
";
    }

    // line 7
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        echo "    <!-- MAIN: Start -->
    <main class=\"main boxed\">
        <h2>Récapitulatif des utilisateurs</h2>

        <!-- BUTTONS: End -->

        <!-- TABLE: Start -->
        <table id=\"user_list\" class=\"display\"></table>
        <!-- TABLE: End -->
    </main>
    <!-- MAIN: End -->

    <aside class=\"u_managment boxed\">
        <h2 class=\"u_managment__title\">Editer utilisateur</h2>

        <form class=\"u_managment__form\">

            <h3>Informations principales</h3>

            <input class=\"form__field\" type=\"text\" name=\"uid\" id=\"uid\" placeholder=\"ID AC\" disabled=\"true\" />
            <input class=\"form__field\" type=\"text\" name=\"beneficiary\" id=\"beneficiary\" placeholder=\"Numéro de bénéficiaire\" /><br/>
            <input class=\"form__field\" type=\"text\" name=\"lastname\" id=\"lastname\" placeholder=\"Nom\" />
            <input class=\"form__field\" type=\"text\" name=\"firstname\" id=\"firstname\" placeholder=\"Prénom\" />
            <input class=\"form__field\" type=\"email\" name=\"email\" id=\"email\" placeholder=\"Adresse mail\" />
            <input class=\"form__field\" type=\"tel\" name=\"phone\" id=\"phone\" placeholder=\"Numéro de téléphone\" />

            <h3>Droits sur les applications</h3>
            <div class=\"form__field\">
                <label for=\"app_ticket\">Audace</label>
                <select name=\"app_audace\" id=\"app_audace\">
                    <option value=\"none\">Aucun</option>
                    <option value=\"none\" selected>Utilisateur</option>
                    <option value=\"none\">Administrateur</option>
                </select>
            </div>

            <div class=\"form__field\">
                <label for=\"app_ticket\">AfpaTicket</label>
                <select name=\"app_ticket\" id=\"app_ticket\">
                    <option value=\"none\">Aucun</option>
                    <option value=\"none\" selected>Utilisateur</option>
                    <option value=\"none\">Administrateur</option>
                </select>
            </div>

            <div class=\"form__field\">
                <label for=\"app_ticket\">Afpanier</label>
                <select name=\"app_panier\" id=\"app_panier\">
                    <option value=\"none\">Aucun</option>
                    <option value=\"none\" selected>Utilisateur</option>
                    <option value=\"none\">Administrateur</option>
                </select>
            </div>

            <button class=\"form__submit btn\" type=\"submit\">Éditer l'utilisateur</button>
        </form>
    </aside>
";
    }

    public function getTemplateName()
    {
        return "user/manage.html.twig";
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
    Récapitulatif - {{ parent() }}
{% endblock %}

{% block content %}
    <!-- MAIN: Start -->
    <main class=\"main boxed\">
        <h2>Récapitulatif des utilisateurs</h2>

        <!-- BUTTONS: End -->

        <!-- TABLE: Start -->
        <table id=\"user_list\" class=\"display\"></table>
        <!-- TABLE: End -->
    </main>
    <!-- MAIN: End -->

    <aside class=\"u_managment boxed\">
        <h2 class=\"u_managment__title\">Editer utilisateur</h2>

        <form class=\"u_managment__form\">

            <h3>Informations principales</h3>

            <input class=\"form__field\" type=\"text\" name=\"uid\" id=\"uid\" placeholder=\"ID AC\" disabled=\"true\" />
            <input class=\"form__field\" type=\"text\" name=\"beneficiary\" id=\"beneficiary\" placeholder=\"Numéro de bénéficiaire\" /><br/>
            <input class=\"form__field\" type=\"text\" name=\"lastname\" id=\"lastname\" placeholder=\"Nom\" />
            <input class=\"form__field\" type=\"text\" name=\"firstname\" id=\"firstname\" placeholder=\"Prénom\" />
            <input class=\"form__field\" type=\"email\" name=\"email\" id=\"email\" placeholder=\"Adresse mail\" />
            <input class=\"form__field\" type=\"tel\" name=\"phone\" id=\"phone\" placeholder=\"Numéro de téléphone\" />

            <h3>Droits sur les applications</h3>
            <div class=\"form__field\">
                <label for=\"app_ticket\">Audace</label>
                <select name=\"app_audace\" id=\"app_audace\">
                    <option value=\"none\">Aucun</option>
                    <option value=\"none\" selected>Utilisateur</option>
                    <option value=\"none\">Administrateur</option>
                </select>
            </div>

            <div class=\"form__field\">
                <label for=\"app_ticket\">AfpaTicket</label>
                <select name=\"app_ticket\" id=\"app_ticket\">
                    <option value=\"none\">Aucun</option>
                    <option value=\"none\" selected>Utilisateur</option>
                    <option value=\"none\">Administrateur</option>
                </select>
            </div>

            <div class=\"form__field\">
                <label for=\"app_ticket\">Afpanier</label>
                <select name=\"app_panier\" id=\"app_panier\">
                    <option value=\"none\">Aucun</option>
                    <option value=\"none\" selected>Utilisateur</option>
                    <option value=\"none\">Administrateur</option>
                </select>
            </div>

            <button class=\"form__submit btn\" type=\"submit\">Éditer l'utilisateur</button>
        </form>
    </aside>
{% endblock %}", "user/manage.html.twig", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\app\\views\\user\\manage.html.twig");
    }
}
