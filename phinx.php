<?php
require 'public/index.php';

/* @var $pdo PDO */
$pdo = $app->getContainer()->get('db')->getPDO();
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

return [
    'paths'        => [
        'migrations' => $app->getContainer()->get(\Core\ModulesContainer::class)->getMigrations(),
        'seeds'      => $app->getContainer()->get(\Core\ModulesContainer::class)->getSeeders()
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