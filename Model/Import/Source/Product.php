<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\ImportExport\Model\Import\Source;

/**
 * CSV import adapter
 */
class Product extends \Magento\ImportExport\Model\Import\Source\Csv
{
    private $descriptions = [
        "description1",
        "description2",
        "description3",
        "description4"
    ];

    public function __construct(
        $file,
        \Magento\Framework\Filesystem\Directory\Read $directory,
        $delimiter = ';',
        $enclosure = '"'
    )
    {
        parent::__construct($file, $directory, ";", $enclosure);
    }

    public function current()
    {
        $descriptions = [];

        $rowData = parent::current();
        $rowData["product_type"] = "simple";
        $rowData["_attribute_set"] = "Default";
        $rowData["url_key"] = $rowData["sku"];
        $rowData["price"] = str_replace(",", ".", $rowData["price"]);
        $rowData["product_websites"] = "admin";
        foreach ($this->descriptions as $description_key)
        {
            if(isset($rowData[$description_key]))
            {
                if(!empty($rowData[$description_key]))
                {
                    $descriptions[] = $rowData[$description_key];
                    unset($rowData[$description_key]);
                }
            }
        }
        if(isset($rowData["online_catalog"]))
        {
            if($rowData["online_catalog"] == "igen")
            {
                $rowData["online_catalog"] = __("Yes")->render();
            }
            if($rowData["online_catalog"] == "nem")
            {
                $rowData["online_catalog"] = __("No")->render();
            }
        }
        if(isset($rowData["printed_catalog"]))
        {
            if($rowData["printed_catalog"] == "igen")
            {
                $rowData["printed_catalog"] = __("Yes")->render();
            }
            if($rowData["printed_catalog"] == "nem")
            {
                $rowData["printed_catalog"] = __("No")->render();
            }
        }
        if(isset($rowData["partner_program"]))
        {
            if($rowData["partner_program"] == "igen")
            {
                $rowData["partner_program"] = __("Yes")->render();
            }
            if($rowData["partner_program"] == "nem")
            {
                $rowData["partner_program"] = __("No")->render();
            }
        }
        if(isset($rowData["status"]))
        {
            if($rowData["status"] == "aktív")
            {
                $rowData["product_online"] = 1;
            }
            if($rowData["status"] == "tiltott")
            {
                $rowData["product_online"] = 2;
            }
        }
        $rowData['short_description'] = implode('<br>', $descriptions);
        if(!empty($rowData["categ1"]) && !empty($rowData["categ2"])) {
            $rowData["categories"] = "Default Category" . "/" . $rowData["categ1"] . "/" . $rowData["categ2"];
            unset($rowData["categ1"]);
            unset($rowData["categ2"]);
        }
        return $rowData;
    }
}
