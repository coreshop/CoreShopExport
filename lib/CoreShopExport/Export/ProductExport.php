<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Category;
use CoreShop\Model\Product;

class ProductExport extends AbstractPimcoreExport
{
    public function getType()
    {
        return 'product';
    }

    public function exportAll()
    {
         $nameMap = [
            'articleNumber' => 'sku',
            'shops' => 'stores',
            'filterDefinition' => 'filter'
        ];

        $skip = [
            'availableForOrder',
            'fieldCollections',
            'customProperties',
            'variants',
            'isVirtualProduct',
            'virtualAsset'
        ];

        $convert = [
            'retailPrice' => [
                'type' => 'coreShopMoney',
                'name' => 'pimcoreBasePrice',
                'transform' => function($value) {
                    return intval($value * 100);
                }
            ],
            'wholesalePrice' => [
                'type' => 'coreShopMoney',
                'name' => 'wholesalePrice',
                'transform' => function($value) {
                    return intval($value * 100);
                }
            ],
            'supplierWholesalePrice' => [
                'type' => 'coreShopMoney',
                'name' => 'supplierWholesalePrice',
                'transform' => function($value) {
                    return intval($value * 100);
                }
            ],
            'productSpecificPrices' => [
                'type' => 'coreShopProductSpecificPriceRules',
                'name' => 'specificPriceRules'
            ]
        ];

        return $this->export(Product::getPimcoreObjectClass(), [], $nameMap, $skip, $convert);
    }

}