<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Zone;

final class ZoneExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'zone';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $zonesExport = [];

        $zones = Zone::getList();
        $zones = $zones->load();

        /**
         * @var $zone Zone
         */
        foreach ($zones as $zone) {
            $zoneExport = [
                'id' => $zone->getId(),
                'name' => $zone->getName(),
                'active' => $zone->getActive()
            ];

            $zonesExport[] = $zoneExport;
        }

        return $zonesExport;
    }
}