<?php 
namespace OSW3\Breadcrumb\Service;

use ReflectionClass;
use OSW3\Breadcrumb\Attribute\Breadcrumb;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class BreadcrumbService
{
    private array $items = [];

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();
        
        if (!is_array($controller)) 
        {
            return;
        }
        
        [$controllerObject, $methodName] = $controller;

        $reflectionClass = new ReflectionClass($controllerObject);
        $reflectionMethod = $reflectionClass->getMethod($methodName);

        $attributes = $reflectionMethod->getAttributes(Breadcrumb::class);

        
        foreach ($attributes as $attribute) 
        {
            /** @var Breadcrumb $breadcrumb */
            $breadcrumb = $attribute->newInstance();

            $this->items = $breadcrumb->getItems();
        }
    }

    public function getItems(): array 
    {
        return $this->items;
    }
}