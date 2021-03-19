<?php

$sMetadataVersion = '2.0';

$aModule = array(
    'id'           => 'agdeliverytable',
    'title'        => 'Delivery Table',
    'description'  => 'Add method to retrieve delivery table',
    'thumbnail'    => '',
    'version'      => '1.0.1',
    'author'       => 'Aggrosoft GmbH',
    'extend'      => array(
        \OxidEsales\Eshop\Core\ViewConfig::class => Aggrosoft\DeliveryTable\Core\DeliveryTableViewConfig::class
    )
);
