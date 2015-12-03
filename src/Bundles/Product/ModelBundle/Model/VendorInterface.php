<?php

namespace Bundles\Product\ModelBundle\Model;

/**
 * Interface VendorInterface
 *
 * @TODO перенести resolve class  в динамический маппинг, из config.yml
 */
interface VendorInterface
{
    /**
     * @return integer
     */
    public function getId();
}