<?php
namespace OSW3\Breadcrumb\Components;

use OSW3\Breadcrumb\Service\BreadcrumbService;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use OSW3\Breadcrumb\DependencyInjection\Configuration;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsTwigComponent(template: '@Breadcrumb/Breadcrumb.twig')]
final class Breadcrumb
{
    #[ExposeInTemplate(name: 'disabled', getter: 'fetchDisabled')]
    private bool $disabled;

    // #[ExposeInTemplate(name: 'id')]
    public string $id;

    // #[ExposeInTemplate(name: 'class')]
    public string $class;

    public function __construct
    (
        private ParameterBagInterface $params,
        private BreadcrumbService $breadcrumbService
    ){}

    public function mount(?string $id = null, ?string $class = null): void
    {
        $this->disabled = false;
        $this->id       = $id ?? "";
        $this->class    = $class ?? "";
    }

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
}