<?php
namespace OSW3\Breadcrumb\Twig\Components;

use OSW3\Breadcrumb\Service\BreadcrumbService;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use OSW3\Breadcrumb\DependencyInjection\Configuration;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsTwigComponent(template: '@Breadcrumb/Breadcrumb.twig')]
final class Breadcrumb
{
    #[ExposeInTemplate(name: 'id')]
    public string $id;

    #[ExposeInTemplate(name: 'class')]
    public string $class;

    #[ExposeInTemplate(name: 'style', getter: 'fetchStyle')]
    private ?string $style;

    #[ExposeInTemplate(name: 'disabled', getter: 'fetchDisabled')]
    private ?string $disabled;

    public function __construct(
        private ParameterBagInterface $params,
        private BreadcrumbService $breadcrumbService
    ){}

    #[PreMount]
    public function preMount(array $data): array
    {
        // validate data
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        // Custom ID
        $resolver->setDefaults(['id' => ""]);
        $resolver->setAllowedTypes('id', ['string']);

        // Custom Class
        $resolver->setDefaults(['class' => ""]);
        $resolver->setAllowedTypes('class', ['string']);

        return $resolver->resolve($data) + $data;
    }

    public function fetchDisabled(): bool
    {
        $options = $this->params->get(Configuration::NAME);
        $hideEmpty = $options['hide_empty'];
        
        $items = $this->breadcrumbService->getItems();
        
        return empty($items) && $hideEmpty;
    }

    public function fetchStyle(): ?string
    {
        $options = $this->params->get(Configuration::NAME);
        $style = [];

        if ($options['separator']) {
            $style[] = match($options['template'])
            {
                'bootstrap' => "--bs-breadcrumb-divider: '{$options['separator']}';",
                default => "--breadcrumb-divider: '{$options['separator']}';",
            };
        }

        return implode("", $style);
    }
}