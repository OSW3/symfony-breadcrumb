<?php 
namespace OSW3\Breadcrumb\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Breadcrumb
{
    private array $items;

    public function __construct(array $items)
    {
        foreach ($items as $item) 
        {
            if (!isset($item['label'])) {
                throw new \InvalidArgumentException('Each breadcrumb item must have a "label".');
            }

            if (!isset($item['route'])) {
                throw new \InvalidArgumentException('Each breadcrumb item must have a "route".');
            }

            if (!isset($item['params'])) {
                $item['params'] = [];
            }

            if (!isset($item['domain'])) {
                $item['domain'] = null;
            }

            if (!isset($item['lang'])) {
                $item['lang'] = "en";
            }

            if (!isset($item['class'])) {
                $item['class'] = null;
            }

            if (!isset($item['icon'])) {
                $item['icon'] = null;
            }

            $this->items[] = $item;
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }
}