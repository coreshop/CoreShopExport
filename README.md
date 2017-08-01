# CoreShop Export

This plugins exports data from CoreShop 1 to be then imported in CoreShop 2.

## Usage
    - Run CLI Command: ```php pimcore/cli/console.php coreshop-export:export```
    - The Command will store a file within website/var/system
    - Copy that file over to your CoreShop 2 installation and call ```bin/console coreshop:import FILEPATH```
    - The Importer will erase all your existing data!!

## What gets currently exported/imported?
    - Countries
    - Zone
    - States
    - Currencies
    - Tax Rates
    - Tax Rule Groups
    - Shipping Rules
    - Carriers
