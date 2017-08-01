<?php

namespace CoreShopExport\Export;

use CoreShop\Model\Country;

final class CountryExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $countriesExport = [];

        $countries = Country::getList();
        $countries = $countries->load();

        /**
         * @var $country Country
         */
        foreach ($countries as $country) {
            $countryExport = [
                'id' => $country->getId(),
                'name' => $country->getName(),
                'isoCode' => $country->getIsoCode(),
                'active' => $country->getActive(),
                'currency' => $country->getCurrencyId(),
                'zone' => $country->getZoneId(),
                'addressFormat' => $country->getAddressFormat(),
                'shops' => $country->getShopIds(),
            ];

            $countriesExport[] = $countryExport;
        }

        return $countriesExport;
    }
}