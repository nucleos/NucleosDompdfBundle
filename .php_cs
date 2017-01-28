<?php

// try to get Symfony's PHPunit Bridge
$files = array_filter(array(
    __DIR__.'/vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php',
    __DIR__.'/../../../vendor/sllh/php-cs-fixer-styleci-bridge/autoload.php',
), 'file_exists');

if (count($files) > 0) {
    require_once current($files);
}

use SLLH\StyleCIBridge\ConfigBridge;

$header = <<<EOF
(c) Christian Gripp <mail@core23.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

// PHP-CS-Fixer 1.x
if (class_exists('Symfony\CS\Fixer\Contrib\HeaderCommentFixer')) {
    \Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);
}

$config = ConfigBridge::create()
    ->setUsingCache(true)
;

// PHP-CS-Fixer 2.x
if (method_exists($config, 'setRules')) {
    $config->setRules(array_merge($config->getRules(), array(
        'header_comment' => array('header' => $header)
    )));
}

return $config;
