<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Carrier\ShippingRule;

final class ShippingRuleExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'shipping_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $rulesExport = [];

        $shippingRules = ShippingRule::getList();
        $shippingRules = $shippingRules->load();

        /**
         * @var $rule ShippingRule
         */
        foreach ($shippingRules as $rule) {
            $ruleExport = [
                'id' => $rule->getId(),
                'name' => $rule->getName()
            ];
            $actions = [];
            $conditions = [];

            foreach ($rule->getActions() as $action) {
                $actions[] = [
                    'type' => $action::getType(),
                    'configuration' => get_object_vars($action)
                ];
            }

            foreach ($rule->getConditions() as $condition) {
                $conditions[] = [
                    'type' => $condition::getType(),
                    'configuration' => get_object_vars($condition)
                ];
            }

            $ruleExport['actions'] = $actions;
            $ruleExport['conditions'] = $conditions;

            $rulesExport[] = $ruleExport;
        }

        return $rulesExport;
    }
}