<?php 

// this file is used in BreadcrumbBundle.php with  class BreadcrumbBundle extends AbstractBundle
// public function configure(DefinitionConfigurator $definition): void
// {
//     $definition->import(Path::join($this->getPath(), "config/definition/bridge.php"));
// }

use Symfony\Component\Filesystem\Path;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;

return static function (DefinitionConfigurator $configurator): void {
    $definition = require Path::join(__DIR__, "definition.php");
    $definition($configurator);
};