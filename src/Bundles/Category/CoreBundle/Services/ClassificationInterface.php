<?php

namespace Bundles\Category\CoreBundle\Services;

/**
 * Class ClassificationInterface
 */
interface ClassificationInterface
{
    /**
     * Get class name
     *
     * @return string
     */
    public function getEntityClassName();

    /**
     * Get product list according strategy
     *
     * @return array
     */
    public function getProductList();
}