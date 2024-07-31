<?php 
namespace OSW3\Breadcrumb;

use OSW3\Breadcrumb\Components\Breadcrumb;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use OSW3\Breadcrumb\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BreadcrumbBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $projectDir = $container->getParameter('kernel.project_dir');


        // Update dependency config
        // -- 

        $twig_component_Filepath = Path::join($projectDir, 'config/packages/twig_component.yaml' );
        
        if (file_exists($twig_component_Filepath))
        {
            $twig_component_YamlContent = file_get_contents( $twig_component_Filepath );
            $twig_component_ArrayContent = Yaml::parse($twig_component_YamlContent);
            
            // Search Bundle Components namespace
            $classPath = explode("\\", Breadcrumb::class);
            array_pop($classPath);
            $newClassPath = implode("\\", $classPath)."\\";

            if (!isset( $twig_component_ArrayContent['twig_component']['defaults'][$newClassPath] ))
            {
                file_put_contents($twig_component_Filepath, Yaml::dump(array_merge_recursive($twig_component_ArrayContent, ['twig_component' => ['defaults' => [$newClassPath => "@Search/"]]]), 4));
            }
        }

        (new Configuration)->generateProjectConfig($projectDir);
    }
}