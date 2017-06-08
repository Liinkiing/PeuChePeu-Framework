<?php

return [
    'basepath'                     => dirname(__DIR__),
    'settings.debug'               => true,
    'settings.whoops.editor'       => 'sublime',
    'settings.displayErrorDetails' => true,
    \Core\View::class              => \DI\object(\Core\View::class)->constructor(\DI\get('basepath')),
];
