<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Tax;
use Pimcore\Tool;

final class TaxRateExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'tax_rate';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $taxRatesExport = [];

        $taxRates = Tax::getList();
        $taxRates = $taxRates->load();

        /**
         * @var $taxRate Tax
         */
        foreach ($taxRates as $taxRate) {
            $taxRateExport = [
                'id' => $taxRate->getId(),
                'rate' => $taxRate->getRate(),
                'active' => $taxRate->getActive(),
                'name' => []
            ];

            foreach (Tool::getValidLanguages() as $lang) {
                $taxRateExport['name'][$lang] = $taxRate->getName($lang);
            }

            $taxRatesExport[] = $taxRateExport;
        }

        return $taxRatesExport;
    }
}