<?php
/**
 * @category    Genmato
 * @package     Genmato_ReserveOnly
 * @copyright   Copyright (c) 2015 Genmato BV (https://genmato.com)
 */

class Genmato_ReserveOnly_Model_System_Config_Source_Payment
{
    public function toOptionArray()
    {
        $paymentMethods = Mage::getModel('payment/config')->getAllMethods();

        $result = array();
        foreach ($paymentMethods as $code=>$method) {
            $result[] = array(
                'value'=> $code,
                'label'=> $code
            );
        }

        return $result;
    }
}