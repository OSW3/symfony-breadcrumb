<?php 
namespace OSW3\Breadcrumb;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Config\Definition\Processor;
use OSW3\Breadcrumb\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BreadcrumbBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
		$this->container = $container;
        $this->writeConfigYaml();
    }
    
	private function getProjectDir(): string
	{
        return $this->container->getParameter('kernel.project_dir');
	}

    private function writeConfigYaml()
    {
        $configFile = Path::join($this->getProjectDir(), "config/packages", Configuration::NAME.".yaml");

        if (!file_exists($configFile))
        {
            $configuration = (new Processor)->processConfiguration(new Configuration(), []);

            file_put_contents($configFile, Yaml::dump([
                Configuration::NAME => $configuration
            ], 4));
        }
    }
}