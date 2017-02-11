<?php
/**
 * Created by PhpStorm.
 * User: pawelzny
 * Date: 11.12.16
 * Time: 11:07
 */

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules(array(
        '@PSR1' => true,
        '@PSR2' => true,
        'array_syntax' => array('syntax' => 'short'),
        'binary_operator_spaces' => true,
        'blank_line_before_return' => true,
        'hash_to_slash_comment' => true,
        'method_separation' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_multiline_whitespace_before_semicolons' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_unused_imports' => true,
        'ordered_imports' => true,
    ))
    ->setFinder($finder);
