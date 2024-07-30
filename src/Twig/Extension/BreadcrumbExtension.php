<?php
namespace OSW3\Breadcrumb\Twig\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use OSW3\Breadcrumb\Twig\Runtime\BreadcrumbRuntime;

class BreadcrumbExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('_add_attribute', [BreadcrumbRuntime::class, 'addAttribute']),
            new TwigFunction('_get_attributes', [BreadcrumbRuntime::class, 'getAttributes'], ['is_safe' => ['html']]),
        ];
    }
}
