<?php 
namespace OSW3\Breadcrumb\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use OSW3\Breadcrumb\DependencyInjection\DefinitionConfigurator;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Filesystem\Path;

class Configuration implements ConfigurationInterface
{
	/**
	 * define the name of the configuration tree.
	 * > /config/packages/breadcrumb.yaml
	 *
	 * @var string
	 */
	public const string NAME = "breadcrumb";

	/**
	 * Define the translation domain
	 *
	 * @var string
	 */
	public const string DOMAIN = 'breadcrumb';

	/**
	 * Update and return the Configuration Builder
	 *
	 * @return TreeBuilder
	 */
	public function getConfigTreeBuilder(): TreeBuilder
    {
        $definition = require Path::join(__DIR__, "../../", "config/definition/definition.php");
        $builder    = new TreeBuilder( static::NAME );

        $definition(new DefinitionConfigurator($builder->getRootNode()));

		return $builder;
    }
}