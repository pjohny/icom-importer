<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Icom\Importer\Plugin\Backend\Magento\Framework\File;

class Uploader
{

    public function beforeSetAllowedExtensions(
        \Magento\Framework\File\Uploader $subject,
        $extensions = []
    ) {
        //Your plugin code
        if(in_array("csv", $extensions) && in_array("zip", $extensions))
        {
            $extensions[] = "icom";
            $extensions[] = "product";
        }
        return [$extensions];
    }
}