<?php

namespace Kruzhalin\DisplayDiscount\Plugin;

use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OrderGridCollection;

/**
 * Class AddFieldsToOrdersGrid
 *
 * @package Kruzhalin\DisplayDiscount\Plugin
 */
class AddFieldsToOrdersGrid
{
    /**
     * @param CollectionFactory   $subject
     * @param OrderGridCollection $collection
     * @param                     $requestName
     * @return mixed
     */
    public function afterGetReport($subject, $collection, $requestName)
    {
        if ($requestName !== 'sales_order_grid_data_source') {
            return $collection;
        }
        if ($collection->getMainTable() !== $collection->getResource()->getTable('sales_order_grid')) {
            return $collection;
        }

        $collection->getSelect()->joinLeft(
            $collection->getResource()->getTable('sales_order'),
            'main_table.entity_id = sales_order.entity_id',
            ['coupon_code', 'base_discount_amount', 'discount_amount']
        );

        return $collection;
    }
}
