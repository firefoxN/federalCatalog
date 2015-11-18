<?php
/**
 * Created by PhpStorm.
 * User: natali
 * Date: 18.11.15
 * Time: 14:34
 */

namespace Bundles\Category\ModelBundle\Model;

/**
 * Interface ClassificationInterface
 */
interface ClassificationInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getSlug();
}