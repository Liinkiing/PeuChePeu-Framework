<?php
require 'public/index.php';

/* @var $pdo PDO */
$pdo = $app->getContainer()->get('db')->getPDO();
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$modules = $app->getModules();

$migrations = [];
$seeders = [];

foreach ($modules as $module) {
    $reflexion = new ReflectionClass($module);
    $migrations[] = $reflexion->getConstant('MIGRATIONS');
    $seeds[] = $reflexion->getConstant('SEEDS');
}

return [
    'paths'        => [
        'migrations' => array_filter($migrations),
        'seeds'      => array_filter($seeders)
    ],
    'environments' =>
        [
            'default_database' => 'development',
            'development'      => [
                'name'       => $app->getContainer()->get('db')->database,
                'connection' => $pdo
            ]
        ]
];