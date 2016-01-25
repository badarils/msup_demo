<?php
/**
 * Created by Magentix
 * Based on Module from "Excellence Technologies" (excellencetechnologies.in)
 *
 * @category   Magentix
 * @package    Magentix_Convenience
 * @author     Matthieu Vion (http://www.magentix.fr)
 * @license    This work is free software, you can redistribute it and/or modify it
 */

$installer = $this;

$installer->startSetup();

$installer->run("
    ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `convenience_amount_invoiced` DECIMAL( 10, 2 ) NOT NULL;
    ALTER TABLE  `".$this->getTable('sales/order')."` ADD  `base_convenience_amount_invoiced` DECIMAL( 10, 2 ) NOT NULL;
");

$installer->endSetup();