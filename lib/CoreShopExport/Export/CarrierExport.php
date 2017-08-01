<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Carrier;

final class CarrierExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'carrier';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $carriersExport = [];

        $carriers = Carrier::getList();
        $carriers = $carriers->load();

        /**
         * @var $carrier Carrier
         */
        foreach ($carriers as $carrier) {
            $carrierExport = [
                'id' => $carrier->getId(),
                'name' => $carrier->getName(),
                'label' => $carrier->getLabel(),
                'delay' => $carrier->getDelay(),
                'grade' => $carrier->getGrade(),
                'image' => $carrier->getImage(),
                'trackingUrl' => $carrier->getTrackingUrl(),
                'isFree' => $carrier->getIsFree(),
                'taxRuleGroupId' => $carrier->getTaxRuleGroupId(),
                'rangeBehaviour' => $carrier->getRangeBehaviour(),
                'shops' => $carrier->getShopIds(),
            ];
            $shippingRuleGroups = [];

            foreach ($carrier->getShippingRuleGroups() as $shippingRuleGroup) {
                $shippingRuleGroups[] = [
                    'id' => $shippingRuleGroup->getId(),
                    'priority' => $shippingRuleGroup->getPriority(),
                    'shippingRule' => $shippingRuleGroup->getShippingRuleId()
                ];
            }

            $carrierExport['shippingRuleGroups'] = $shippingRuleGroups;

            $carriersExport[] = $carrierExport;
        }

        return $carriersExport;
    }
}