<?php

namespace CoreShopExport\Console\Command;

use CoreShopExport\Export\AssetExport;
use CoreShopExport\Export\CarrierExport;
use CoreShopExport\Export\CategoryExport;
use CoreShopExport\Export\CountryExport;
use CoreShopExport\Export\CurrencyExport;
use CoreShopExport\Export\ExportInterface;
use CoreShopExport\Export\ManufacturerExport;
use CoreShopExport\Export\ProductExport;
use CoreShopExport\Export\ShippingRuleExport;
use CoreShopExport\Export\StateExport;
use CoreShopExport\Export\StoreExport;
use CoreShopExport\Export\TaxRateExport;
use CoreShopExport\Export\TaxRuleGroupExport;
use CoreShopExport\Export\ZoneExport;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('coreshop-export:export')
            ->setDescription('Export All of CoreShops Data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->disableLogging();

        $exports = [
            ShippingRuleExport::class,
            CarrierExport::class,
            CountryExport::class,
            ZoneExport::class,
            CurrencyExport::class,
            StoreExport::class,
            TaxRateExport::class,
            TaxRuleGroupExport::class,
            StateExport::class,
            ManufacturerExport::class,
            CategoryExport::class,
            ProductExport::class,
            AssetExport::class
        ];

        $this->output->writeln('<info>Found '.count($exports).' ExportDefinitions to run</info>');

        $progress = new ProgressBar($output, count($exports));
        $progress->start();

        $exportResult = [];

        foreach ($exports as $export) {
            $exportClass = new $export();

            if ($exportClass instanceof ExportInterface) {
                $exportResult[$exportClass->getType()] = $exportClass->exportAll();
            }

            $progress->advance();
        }

        $progress->finish();
        $output->writeln("");

        $filename = sprintf("%s/coreshop-export-dump-%s.json", PIMCORE_SYSTEM_TEMP_DIRECTORY, time());

        file_put_contents($filename, json_encode($exportResult, JSON_PRETTY_PRINT));

        $output->writeln(sprintf("<info>Dumped export file at %s</info>", $filename));
    }
}