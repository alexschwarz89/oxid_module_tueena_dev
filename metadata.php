<?php

$aModule = array(
    'id'           => 'tueena_dev',
    'title'        => 'tueena_dev',
    'description'  => 'This module should help developing OXID modules.',
    'thumbnail'    => '',
    'version'      => '1.0',
    'author'       => 'bastian.fenske@tueena.com',
    'extend'       => array(
        'oxmodule' => 'tueena_moduledev/core/tueena_moduledev_core_module',
        'oxmodulelist' => 'tueena_moduledev/core/tueena_moduledev_core_modulelist',
    )
);