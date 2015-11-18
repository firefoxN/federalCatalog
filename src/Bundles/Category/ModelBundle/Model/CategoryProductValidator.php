<?php
namespace Bundles\Category\ModelBundle\Model;

use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * Class CategoryProductValidator
 *
 * @package Bundles\Category\ModelBundle\Model
 */
class CategoryProductValidator
{
    /**
     * @param mixed $obj
     *
     * @return ProductInterface
     */
    public static function getValidSubject($obj)
    {
        if (!is_object($obj) && !($obj instanceof ProductInterface)) {
            throw new InvalidArgumentException('The product for category is not valid');
        }

        return $obj;
    }

}