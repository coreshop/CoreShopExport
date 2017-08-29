<?php

namespace CoreShopExport\Export;

use Pimcore\Model\Asset;
use Pimcore\Tool;

final class AssetExport implements ExportInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'asset';
    }

    /**
     * {@inheritdoc}
     */
    public function exportAll()
    {
        $assetsExport = [];

        $assets = Asset::getList();
        $assets = $assets->load();

        /**
         * @var $asset Asset
         */
        foreach ($assets as $asset) {
            $assetExport = get_object_vars($asset);
            $assetExport['url'] = Tool::getHostUrl() . "/" . $asset->getFullPath();

            $assetsExport[] = $assetExport;
        }

        return $assetsExport;
    }
}