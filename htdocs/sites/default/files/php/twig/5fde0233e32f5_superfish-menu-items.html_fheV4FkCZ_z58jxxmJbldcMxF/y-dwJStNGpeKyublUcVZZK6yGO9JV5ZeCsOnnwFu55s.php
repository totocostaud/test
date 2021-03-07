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

/* modules/contrib/superfish/templates/superfish-menu-items.html.twig */
class __TwigTemplate_7e090c704574390b2a4bab895f4e5ee2abe5908c450fcc626b2d68bc2f578bec extends \Twig\Template
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
        $tags = array("set" => 22, "spaceless" => 23, "for" => 24, "if" => 26);
        $filters = array("escape" => 33);
        $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'spaceless', 'for', 'if'],
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
        // line 21
        echo "
";
        // line 22
        $context["classes"] = [];
        // line 23
        ob_start(function () { return ''; });
        // line 24
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["menu_items"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 25
            echo "
  ";
            // line 26
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 26))) {
                // line 27
                echo "    ";
                $context["item_class"] = ($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "item_class", [], "any", false, false, true, 27), 27, $this->source) . " menuparent");
                // line 28
                echo "    ";
                if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_column", [], "any", false, false, true, 28)) {
                    // line 29
                    echo "      ";
                    $context["item_class"] = ($this->sandbox->ensureToStringAllowed(($context["item_class"] ?? null), 29, $this->source) . " sf-multicolumn-column");
                    // line 30
                    echo "    ";
                }
                // line 31
                echo "  ";
            }
            // line 32
            echo "
  <li";
            // line 33
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 33), 33, $this->source), "html", null, true);
            echo ">
    ";
            // line 34
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_column", [], "any", false, false, true, 34)) {
                // line 35
                echo "    <div class=\"sf-multicolumn-column\">
    ";
            }
            // line 37
            echo "    ";
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 37))) {
                // line 38
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "link_menuparent", [], "any", false, false, true, 38), 38, $this->source), "html", null, true);
                echo "
    ";
            } else {
                // line 40
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, true, 40), 40, $this->source), "html", null, true);
                echo "
    ";
            }
            // line 42
            echo "    ";
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_wrapper", [], "any", false, false, true, 42)) {
                echo "<ul class=\"sf-multicolumn\">
    <li class=\"sf-multicolumn-wrapper ";
                // line 43
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "item_class", [], "any", false, false, true, 43), 43, $this->source), "html", null, true);
                echo "\">
    ";
            }
            // line 45
            echo "    ";
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 45))) {
                // line 46
                echo "      ";
                if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_content", [], "any", false, false, true, 46)) {
                    echo "<ol>";
                } else {
                    echo "<ul>";
                }
                // line 47
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 47), 47, $this->source), "html", null, true);
                echo "
      ";
                // line 48
                if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_content", [], "any", false, false, true, 48)) {
                    echo "</ol>";
                } else {
                    echo "</ul>";
                }
                // line 49
                echo "    ";
            }
            // line 50
            echo "    ";
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_wrapper", [], "any", false, false, true, 50)) {
                echo "</li></ul>";
            }
            // line 51
            echo "    ";
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_column", [], "any", false, false, true, 51)) {
                echo "</div>";
            }
            // line 52
            echo "  </li>

";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "modules/contrib/superfish/templates/superfish-menu-items.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  165 => 52,  160 => 51,  155 => 50,  152 => 49,  146 => 48,  141 => 47,  134 => 46,  131 => 45,  126 => 43,  121 => 42,  115 => 40,  109 => 38,  106 => 37,  102 => 35,  100 => 34,  96 => 33,  93 => 32,  90 => 31,  87 => 30,  84 => 29,  81 => 28,  78 => 27,  76 => 26,  73 => 25,  69 => 24,  67 => 23,  65 => 22,  62 => 21,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/superfish/templates/superfish-menu-items.html.twig", "/Users/christinemarquaire/Sites/latribunepresse.local/htdocs/modules/contrib/superfish/templates/superfish-menu-items.html.twig");
    }
}
