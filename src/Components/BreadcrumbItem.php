<?php
namespace OSW3\Breadcrumb\Components;

use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent(template: '@Breadcrumb/BreadcrumbItem.twig')]
final class BreadcrumbItem
{
    #[ExposeInTemplate(name: 'label')]
    public string $label;

    #[ExposeInTemplate(name: 'domain')]
    public ?string $domain;

    #[ExposeInTemplate(name: 'lang')]
    public string $lang;

    #[ExposeInTemplate(name: 'active')]
    public bool $active;

    #[ExposeInTemplate(name: 'icon')]
    public ?string $icon;

    #[ExposeInTemplate(name: 'route')]
    public string $route;

    #[ExposeInTemplate(name: 'class', getter: 'fetchClass')]
    public ?string $class;

    #[PreMount]
    public function preMount(array $data): array
    {
        // validate data
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults(['label' => ""]);
        $resolver->setAllowedTypes('label', ['string']);

        $resolver->setDefaults(['domain' => null]);
        $resolver->setAllowedTypes('domain', ['null','string']);

        $resolver->setDefaults(['lang' => "en"]);
        $resolver->setAllowedTypes('lang', ['string']);

        $resolver->setDefaults(['active' => false]);
        $resolver->setAllowedTypes('active', ['bool']);

        $resolver->setDefaults(['icon' => ""]);
        $resolver->setAllowedTypes('icon', ['string', 'null']);

        $resolver->setDefaults(['class' => ""]);
        $resolver->setAllowedTypes('class', ['string', 'null']);

        $resolver->setDefaults(['route' => ""]);
        $resolver->setAllowedTypes('route', ['string']);

        return $resolver->resolve($data) + $data;
    }

    public function fetchClass(): string
    {
        $class = [];
        array_push($class, "breadcrumb-item");

        if ($this->active) {
            array_push($class, "active");
        }

        return implode(" ", $class);
    }
}