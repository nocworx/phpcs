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
  ->setRules(
  [
      '@PER-CS' => true,
      '@PHP82Migration' => true,
      '@PSR12' => true,
      'ordered_imports' => ['sort_algorithm' => 'alpha'],
      'no_unused_imports' => true,
      'unary_operator_spaces' => true,
      'binary_operator_spaces' => true,
      'method_argument_space' => [
          'on_multiline' => 'ensure_fully_multiline',
      ],
      'array_indentation' => true,
      'array_syntax' => ['syntax' => 'short'],
      'backtick_to_shell_exec' => true,
      'braces' => [
          'allow_single_line_closure' => true,
          'position_after_anonymous_constructs' => 'same',
          'position_after_functions_and_oop_constructs' => 'next',
          'position_after_control_structures' => 'same',
      ],
    'indentation_type' => true,
    'method_chaining_indentation' => true,
    'Nocworx/codingstandard' => true,
    'phpdoc_to_param_type' => false,
    'phpdoc_to_property_type' => false,
    'phpdoc_to_return_type' => false,
  ]
)
  ->setFinder($finder)->setIndent('  ');

