<?php

$aModule = array(
    'id'           => 'tueena_dev',
    'title'        => 'tueena_dev',
    'description'  => 'This module should help developing OXID modules.',
    'thumbnail'    => '',
    'version'      => '1.0',
    'author'       => 'bastian.fenske@tueena.com',
    'extend' => array(
        'oxmodule' => 'tueena_dev/core/tueena_dev_core_module',
        'oxmodulelist' => 'tueena_dev/core/tueena_dev_core_modulelist',
        'oxshopcontrol' => 'tueena_dev/views/tueena_dev_views_shopcontrol',
    ),
);