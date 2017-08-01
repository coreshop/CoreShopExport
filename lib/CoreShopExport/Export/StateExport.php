<?php

namespace CoreShopExport\Export;

use CoreShop\Model\State;

final class StateExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'state';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $statesExport = [];

        $states = State::getList();
        $states = $states->load();

        /**
         * @var $state State
         */
        foreach ($states as $state) {
            $stateExport = [
                'id' => $state->getId(),
                'name' => $state->getName(),
                'isoCode' => $state->getIsoCode(),
                'active' => $state->getActive(),
                'country' => $state->getCountryId()
            ];

            $statesExport[] = $stateExport;
        }

        return $statesExport;
    }
}