<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Manufacturer;

class ManufacturerExport extends AbstractPimcoreExport
{
    public function getType()
    {
        return 'manufacturer';
    }

    public function exportAll()
    {
        return $this->export(Manufacturer::getPimcoreObjectClass());
    }

}