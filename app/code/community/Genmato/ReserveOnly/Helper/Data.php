<?php
/**
 * @category    Genmato
 * @package     Genmato_ReserveOnly
 * @copyright   Copyright (c) 2015 Genmato BV (https://genmato.com)
 */

class Genmato_ReserveOnly_Helper_Data extends Mage_Core_Helper_Abstract
{

    const ORDER_NORMAL   = 1;
    const ORDER_RESERVED = 2;
    const ORDER_MIXED    = 3;

    /**
     * Check if order contains Reserved products or is a mixed order
     *
     * @param $quote
     * @return int
     */
    public function checkReservedProducts($quote)
    {

        $productIds = array();
        foreach ($quote->getAllItems() as $item) {
            $productIds[] = $item->getProductId();
        }

        $collection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('reserved_product_only')
            ->addFieldToFilter('entity_id', array('in'=>$productIds));

        $reservedCount = 0;
        $itemCount = $collection->getSize();
        foreach ($collection as $product) {
            if ($product->getReservedProductOnly()==1) {
                $reservedCount++;
            }
        }

        if ($reservedCount>0 && $reservedCount<>$itemCount) {
            return self::ORDER_MIXED;
        } elseif($reservedCount>0 && $reservedCount==$itemCount) {
            return self::ORDER_RESERVED;
        } else {
            return self::ORDER_NORMAL;
        }
    }
}