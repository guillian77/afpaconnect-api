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

/* user/upload.html.twig */
class __TwigTemplate_7ff9102539ea5e3fde1f3d4fdf5278b24593ed0dc4a3aeea1df782e944818232 extends Template
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
        $this->parent = $this->loadTemplate("layout.html.twig", "user/upload.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    Ajout utilisateurs - ";
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
        <h2>Téléversement des utilisateurs</h2>
        <div id=\"alert\" class=\"alert d-none\"></div>
        <input id=\"id_user_center\" type=\"hidden\" value=\"<?= \$user_center_id ?>\"/>
        <form method=\"post\" action=\"user_upload\" method=\"POST\" enctype=\"multipart/form-data\">
            <select class=\"select\" id=\"center\"></select>
            <input hidden id=\"upload_file\" type=\"file\" name=\"upload_user\" accept=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel\"/>
        </form>
        <div class=\"drop_file_zone\" ondrop=\"upload_file(event)\" ondragover=\"return false\">
            <label for=\"upload_file\">
                <div class=\"upload-zone\">
                    <p>Sélectionner ou déposer un fichier</p>
                    <img src=\"https://img.icons8.com/carbon-copy/100/000000/download.png\"/>
                </div>
            </label>
        </div>


        <div class=\"center\" id=\"upload_confirm\"></div>
        <!-- TABLE: End -->
    </main>

    </aside>
";
    }

    public function getTemplateName()
    {
        return "user/upload.html.twig";
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
    Ajout utilisateurs - {{ parent() }}
{% endblock %}

{% block content %}
    <!-- MAIN: Start -->
    <main class=\"main boxed\">
        <h2>Téléversement des utilisateurs</h2>
        <div id=\"alert\" class=\"alert d-none\"></div>
        <input id=\"id_user_center\" type=\"hidden\" value=\"<?= \$user_center_id ?>\"/>
        <form method=\"post\" action=\"user_upload\" method=\"POST\" enctype=\"multipart/form-data\">
            <select class=\"select\" id=\"center\"></select>
            <input hidden id=\"upload_file\" type=\"file\" name=\"upload_user\" accept=\"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel\"/>
        </form>
        <div class=\"drop_file_zone\" ondrop=\"upload_file(event)\" ondragover=\"return false\">
            <label for=\"upload_file\">
                <div class=\"upload-zone\">
                    <p>Sélectionner ou déposer un fichier</p>
                    <img src=\"https://img.icons8.com/carbon-copy/100/000000/download.png\"/>
                </div>
            </label>
        </div>


        <div class=\"center\" id=\"upload_confirm\"></div>
        <!-- TABLE: End -->
    </main>

    </aside>
{% endblock %}", "user/upload.html.twig", "Z:\\Users\\Dekadmin\\Desktop\\afpaconnect\\app\\views\\user\\upload.html.twig");
    }
}
