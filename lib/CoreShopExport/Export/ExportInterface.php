<?php

namespace CoreShopExport\Export;

interface ExportInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return array
     */
    public function exportAll();
}