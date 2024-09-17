<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$container = new ContainerBuilder();
$phpLoader = new PhpFileLoader($container, new FileLocator());
$instanceof = [];
$configurator = new ContainerConfigurator($container, $phpLoader, $instanceof, __DIR__, __FILE__);
$services = $configurator->services();
$services
  ->defaults()
  ->autowire()
  ->autowire()
  ->autoconfigure()
  ->load('Symplify\CodingStandard\\', __DIR__ . '/vendor/symplify/coding-standard/src/*')
  ->load('PhpCsFixer\\', __DIR__ . '/vendor/friendsofphp/php-cs-fixer/src/*')
  ->set(Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer::class)
  ->public(true);
$container->compile();

$finder = (new PhpCsFixer\Finder())
  ->in(__DIR__);

return (new PhpCsFixer\Config())
  ->setRiskyAllowed(true)
  ->registerCustomFixers([
    $container->get(Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer::class),
  ])
  ->setRules([
    '@PER-CS' => true,
    '@PHP82Migration' => true,
    'Symplify/codingstandard' => true,
    'trailing_comma_in_multiline' => true,
  ])
  ->setFinder($finder);
