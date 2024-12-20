<?php 
namespace OSW3\Breadcrumb\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class BreadcrumbRuntime implements RuntimeExtensionInterface
{
    public function addAttribute(array $attributes=[], ?string $name=null, mixed $value=null): array
    {
        $attributes[$name] = $value;
        return $attributes;
    }

    /**
     * Render HTML Tags Attributes
     *
     * @param [type] $custom
     * @param array $base
     * @return string
     */
    public function getAttributes($custom, array $base = []): string 
    {
        $str = "";

        $attr = $custom + $base;

        foreach ($custom as $key => $value) {
            if (array_key_exists($key, $base)) {
                $attr[$key] = $base[$key] . ' ' . $value;
            }
        }

        foreach ($attr as $key => $value)
        {
            $_value = trim($value);

            if (!empty($_value) || $_value === "0")
            {
                $str .= !empty($str) ? " " : null;
                $str .= $value === true ? $key : "{$key}=\"{$_value}\"";
            }
        }

        return $str;
    }
}