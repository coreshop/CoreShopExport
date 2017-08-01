<?php

namespace CoreShopExport\Export;

use CoreShop\Model\TaxRuleGroup;

final class TaxRuleGroupExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'tax_rule_group';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $taxRuleGroupsExport = [];

        $taxRuleGroups = TaxRuleGroup::getList();
        $taxRuleGroups = $taxRuleGroups->load();

        /**
         * @var $taxRuleGroup TaxRuleGroup
         */
        foreach ($taxRuleGroups as $taxRuleGroup) {
            $taxRuleGroupExport = [
                'id' => $taxRuleGroup->getId(),
                'name' => $taxRuleGroup->getName(),
                'stores' => $taxRuleGroup->getShopIds()
            ];

            $taxRules = [];

            foreach ($taxRuleGroup->getRules() as $taxRule) {
                $taxRules[] = [
                    'countryId' => $taxRule->getCountryId(),
                    'stateId' => $taxRule->getStateId(),
                    'taxRateId' => $taxRule->getTaxId(),
                    'behaviour' => $taxRule->getBehavior()
                ];
            }

            $taxRuleGroupExport['rules'] = $taxRules;

            $taxRuleGroupsExport[] = $taxRuleGroupExport;
        }

        return $taxRuleGroupsExport;
    }
}