<?php
/**
 * @category    Genmato
 * @package     Genmato_ReserveOnly
 * @copyright   Copyright (c) 2015 Genmato BV (https://genmato.com)
 */

$installer = $this;

$installer->startSetup();

$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'reserved_product_only',
    array(
        'group' => 'Reserve Product',
        'type' => 'int',
        'backend' => '',
        'frontend' => '',
        'label' => 'Reservable Product',
        'input' => 'boolean',
        'source' => 'eav/entity_attribute_source_table',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible' => true,
        'required' => false,
        'user_defined' => true,
        'default' => '',
        'searchable' => false,
        'comparable' => false,
        'unique' => false,
        'sort_order' => 1,
        'used_in_product_listing' => 1 // To force column in flat table
    )
);

$installer->endSetup();