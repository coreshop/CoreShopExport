<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Currency;

final class CurrencyExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $currenciesExport = [];

        $currencies = Currency::getList();
        $currencies = $currencies->load();

        /**
         * @var $currency Currency
         */
        foreach ($currencies as $currency) {
            $currencyExport = [
                'id' => $currency->getId(),
                'name' => $currency->getName(),
                'isoCode' => $currency->getIsoCode(),
                'active' => $currency->getActive(),
                'numericIsoCode' => $currency->getNumericIsoCode(),
                'symbol' => $currency->getSymbol()
            ];

            $currenciesExport[] = $currencyExport;
        }

        return $currenciesExport;
    }
}