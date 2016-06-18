<?php

$header = <<<EOF
This file is part of the ni-ju-san CMS.

(c) Christian Gripp <mail@core23.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(array(__DIR__))
    ->exclude(array('Tests/Fixtures'))
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        'align_double_arrow',
        'combine_consecutive_unsets',
        'header_comment',
        'long_array_syntax',
        'newline_after_open_tag',
        'no_php4_constructor',
        'ordered_use',
        // 'ordered_class_elements',
        'php_unit_construct',
        'php_unit_strict',
        // 'strict',
        // 'strict_param',
        '-unalign_double_arrow',
        '-unalign_equals',
    ))
    ->setUsingCache(true)
    ->finder($finder)
;
