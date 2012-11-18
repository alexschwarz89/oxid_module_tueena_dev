<?php

$aModule = array(
    'id'           => 'tueena_dev',
    'title'        => 'tueena_dev',
    'description'  => 'This module should help developing OXID modules.',
    'thumbnail'    => '',
    'version'      => '1.2.0',
    'author'       => 'bastian.fenske@tueena.com',
    'extend' => array(
        'oxshopcontrol' => 'tueena_dev/views/tueena_dev_views_shopcontrol',
    ),
);