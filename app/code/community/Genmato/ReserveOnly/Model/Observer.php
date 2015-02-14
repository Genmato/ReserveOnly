<?php
/**
 * @category    Genmato
 * @package     Genmato_ReserveOnly
 * @copyright   Copyright (c) 2015 Genmato BV (https://genmato.com)
 */

class Genmato_ReserveOnly_Model_Observer
{
    const RESERVED_PRODUCT_MSG_XML_PATH = 'catalog/reservedonly/message';

    /**
     * Preserve multiple checks in same request
     *
     * @var bool
     */
    protected $_checked = false;

    /**
     * Result of check for reserved Status
     * @var null
     */
    protected $_reservedStatus = null;

    /**
     * Payment Method used for reserved products
     *
     * @var bool
     */
    protected $_reservedPaymentMethod = false;
    /**
     * Check if current quote order amount is allowed for customer
     *
     * @param Varien_Event_Observer $observer
     */
    public function salesQuoteSaveBefore(Varien_Event_Observer $observer)
    {
        if ($this->_checked) {
            return;
        }
        $quote = $observer->getEvent()->getQuote();

        $reservedStatus = Mage::helper('genmato_reserveonly')->checkReservedProducts($quote);

        if ($reservedStatus==Genmato_ReserveOnly_Helper_Data::ORDER_MIXED) {
            $this->_checked = true;

            $quote->setHasError(true);
            $quote->addErrorInfo(
                'error',
                'genmato_reserveonly',
                null,
                Mage::getStoreConfig(self::RESERVED_PRODUCT_MSG_XML_PATH, $quote->getStoreId()),
                null
            );
        }
    }


    /**
     * Force Reserve payment method on reserve orders
     *
     * @param Varien_Event_Observer $observer
     * @return null
     */
    public function paymentMethodIsActive($observer)
    {
        $checkResult = $observer->getEvent()->getResult();
        $method = $observer->getEvent()->getMethodInstance();

        if ($this->_reservedStatus === null) {
            $quote = Mage::getSingleton('checkout/session')->getQuote();
            $this->_reservedStatus=Mage::helper('genmato_reserveonly')->checkReservedProducts($quote);
            $this->_reservedPaymentMethod = Mage::getStoreConfig(
                'catalog/reservedonly/payment_method',
                $quote->getStoreId()
            );
        }

        if ($this->_reservedStatus==Genmato_ReserveOnly_Helper_Data::ORDER_NORMAL) {
            // Hide Reserved Payment Method for normal orders
            if ($method->getCode() == $this->_reservedPaymentMethod) {
                $checkResult->isAvailable = false;
            }
        } else {
            // Only show Reserved Payment Method for normal orders
            if ($method->getCode() != $this->_reservedPaymentMethod) {
                $checkResult->isAvailable = false;
            }
        }

    }

}