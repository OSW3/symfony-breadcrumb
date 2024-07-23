<?php
namespace OSW3\Breadcrumb\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent(template: '@Breadcrumb/BreadcrumbItemIcon.twig')]
final class BreadcrumbItemIcon
{
    #[ExposeInTemplate(name: 'icon')]
    public ?string $icon;

    #[PreMount]
    public function preMount(array $data): array
    {
        // validate data
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults(['icon' => ""]);
        $resolver->setAllowedTypes('icon', ['string', 'null']);

        return $resolver->resolve($data) + $data;
    }
}