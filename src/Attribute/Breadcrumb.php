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

            if (!isset($item['domain'])) {
                $item['domain'] = null;
            }

            $this->items[] = $item;
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }
}