<?php 
namespace OSW3\Breadcrumb;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use OSW3\Breadcrumb\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BreadcrumbBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        (new Configuration)->generateProjectConfig($container->getParameter('kernel.project_dir'));
    }
}