<?php
namespace OSW3\Breadcrumb\Components;

use OSW3\Breadcrumb\Service\BreadcrumbService;
use Symfony\UX\TwigComponent\Attribute\PreMount;
use OSW3\Breadcrumb\DependencyInjection\Configuration;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsTwigComponent(template: '@Breadcrumb/BreadcrumbList.twig')]
final class BreadcrumbList
{
    #[ExposeInTemplate(name: 'class', getter: 'fetchClass')]
    private ?string $class;

    #[ExposeInTemplate(name: 'items', getter: 'fetchItems')]
    private array $items = [];

    public function __construct(
        private ParameterBagInterface $params,
        private BreadcrumbService $breadcrumbService
    ){}

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined(true);

        $resolver->setDefaults(['items' => []]);
        $resolver->setAllowedTypes('items', ['array']);

        return $resolver->resolve($data) + $data;
    }

    public function fetchClass(): string
    {
        return "breadcrumb";
    }

    public function fetchItems(): array
    {
        $options = $this->params->get(Configuration::NAME);

        $default = [
            'label'  => null,
            'domain' => null,
            'lang'   => null,
            'class'  => null,
            'route'  => null,
            'icon'   => null,
        ];

        $items = [];

        array_push($items, array_merge($default, [
            'label'  => $options['home']['label'],
            'domain' => $options['home']['domain'],
            'lang'   => "en", //$options['home']['domain'],
            'route'  => $options['home']['route'],
            'icon'   => $options['home']['icon'],
        ]));

        foreach ($this->breadcrumbService->getItems() as $item)
        {
            array_push($items, array_merge($default, [
                'label'  => $item['label'],
                'domain' => $item['domain'],
                'lang'   => $item['lang'],
                'route'  => $item['route'],
                'class'  => $item['class'],
                'icon'   => $item['icon'],
            ]));
        }

        return $items;
    }
}