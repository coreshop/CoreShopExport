<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Shop;

final class StoreExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'store';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $storeExport = [];

        $stores = Shop::getList();
        $stores = $stores->load();

        /**
         * @var $store Shop
         */
        foreach ($stores as $store) {
            $zoneExport = [
                'id' => $store->getId(),
                'name' => $store->getName(),
                'isDefault' => $store->getIsDefault(),
                'template' => $store->getTemplate()
            ];

            $storeExport[] = $zoneExport;
        }

        return $storeExport;
    }
}