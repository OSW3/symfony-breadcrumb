<?php 
namespace OSW3\Breadcrumb\DependencyInjection;

class DefinitionConfigurator
{
    private $rootNode;

    public function __construct($rootNode)
    {
        $this->rootNode = $rootNode;
    }

    public function rootNode()
    {
        return $this->rootNode;
    }
}
