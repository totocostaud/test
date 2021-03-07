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

/* themes/latribunepresse/templates/user.html.twig */
class __TwigTemplate_594870587c5e5254748b8763c9a2e629b808779764bd8b86c88f00fc22533ee8 extends \Twig\Template
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
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = array("if" => 14);
        $filters = array("escape" => 12);
        $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 11
        echo "<div id=\"user_details\">
<article";
        // line 12
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 12, $this->source), "html", null, true);
        echo ">

  ";
        // line 14
        if (($context["content"] ?? null)) {
            // line 15
            echo "    
    <h2>Adhérent(e) de Culture Presse</h2>
    <hr class=\"user\">
    
    ";
            // line 19
            if (twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_nim", [], "any", false, false, true, 19)) {
                // line 20
                echo "      <h2>NIM : ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_nim", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
                echo "</h2>
    ";
            }
            // line 21
            echo " 
     
    <hr class=\"user\">
    
    ";
            // line 25
            if (twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_firstname", [], "any", false, false, true, 25)) {
                // line 26
                echo "      Prénom : ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_firstname", [], "any", false, false, true, 26), 26, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 28
            echo "    <br>
    ";
            // line 29
            if (twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_lastname", [], "any", false, false, true, 29)) {
                // line 30
                echo "      Nom : ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_lastname", [], "any", false, false, true, 30), 30, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 32
            echo "    <br>   
    ";
            // line 33
            if (twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_post_code", [], "any", false, false, true, 33)) {
                // line 34
                echo "      Code postal : ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_post_code", [], "any", false, false, true, 34), 34, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 36
            echo "    <br>
    ";
            // line 37
            if (twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_city", [], "any", false, false, true, 37)) {
                // line 38
                echo "      Ville : ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "field_city", [], "any", false, false, true, 38), 38, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 39
            echo " 
    <br>
    ";
            // line 41
            if (twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "member_for", [], "any", false, false, true, 41)) {
                // line 42
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["elements"] ?? null), "member_for", [], "any", false, false, true, 42), 42, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 43
            echo "  
    
  ";
        }
        // line 46
        echo "
</article>
</div>";
    }

    public function getTemplateName()
    {
        return "themes/latribunepresse/templates/user.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  150 => 46,  145 => 43,  139 => 42,  137 => 41,  133 => 39,  127 => 38,  125 => 37,  122 => 36,  116 => 34,  114 => 33,  111 => 32,  105 => 30,  103 => 29,  100 => 28,  94 => 26,  92 => 25,  86 => 21,  80 => 20,  78 => 19,  72 => 15,  70 => 14,  65 => 12,  62 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/latribunepresse/templates/user.html.twig", "/Users/christinemarquaire/Sites/latribunepresse.local/htdocs/themes/latribunepresse/templates/user.html.twig");
    }
}
