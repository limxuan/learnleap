<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__) // Include all files in the current directory and subdirectories
    ->exclude(['vendor', 'node_modules']) // Exclude these directories
    ->name('*.php') // Only include PHP files
    ->notName('*.blade.php'); // Exclude specific patterns, if needed

return (new Config())
    ->setRules([
        '@PSR12' => true, // Apply PSR-12 coding standard
        'array_syntax' => ['syntax' => 'short'], // Use short array syntax
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true); // Use caching to speed up subsequent runs
