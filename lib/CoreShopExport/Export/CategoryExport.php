<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Category;

class CategoryExport extends AbstractPimcoreExport
{
    public function getType()
    {
        return 'category';
    }

    public function exportAll()
    {
         $nameMap = [
            'shops' => 'stores',
            'filterDefinition' => 'filter'
        ];

        return $this->export(Category::getPimcoreObjectClass(), ['orderKey' => 'o_path'], $nameMap);
    }

}