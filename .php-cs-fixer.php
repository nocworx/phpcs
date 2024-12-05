<?php

ini_set('memory_limit', -1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;

$folder = realpath(__DIR__);
$container = new ContainerBuilder();
$phpLoader = new PhpFileLoader($container, new FileLocator());
$instanceof = [];
$configurator = new ContainerConfigurator($container, $phpLoader, $instanceof, $folder, __FILE__);
$services = $configurator->services();
$services
    ->defaults()
    ->autowire()
    ->autowire()
    ->autoconfigure()
    ->load('Symplify\CodingStandard\\', $folder . '/vendor/symplify/coding-standard/src/*')
    ->load('PhpCsFixer\\', $folder . '/vendor/friendsofphp/php-cs-fixer/src/*')
    ->set(StandaloneLineInMultilineArrayFixer::class)
    ->public(true);
$container->compile();

$finder = (new Finder())
    ->in(__DIR__);

return (new Config())
    ->setRiskyAllowed(true)
    ->registerCustomFixers([
        $container->get(StandaloneLineInMultilineArrayFixer::class),
    ])
    ->setRules(
        [
            '@PSR12' => true,
            '@PhpCsFixer' => true,
            'blank_line_after_opening_tag' => true,
            'linebreak_after_opening_tag' => true,
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'no_unused_imports' => true,
            'unary_operator_spaces' => true,
            'binary_operator_spaces' => true,
            'no_superfluous_phpdoc_tags' => false,
            'phpdoc_no_package' => false,
            'phpdoc_no_empty_return' => false,
            'phpdoc_no_useless_inheritdoc' => false,
            'concat_space' => ['spacing' => 'one'],
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
            ],
            'control_structure_braces' => true,
            'clean_namespace' => true,
            'single_import_per_statement' => true,
            'single_line_after_imports' => true,
            'array_indentation' => true,
            'array_syntax' => ['syntax' => 'short'],
            'backtick_to_shell_exec' => true,
            'no_extra_blank_lines' => true,
            'single_space_around_construct' => true,
            'indentation_type' => true,
            'no_trailing_whitespace' => true,
            'method_chaining_indentation' => true,
            'Nocworx/codingstandard' => true,
            'phpdoc_to_param_type' => false,
            'phpdoc_to_property_type' => false,
            'phpdoc_to_return_type' => false,
        ]
    )
    ->setFinder($finder);
