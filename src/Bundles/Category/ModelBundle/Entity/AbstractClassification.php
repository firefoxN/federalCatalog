<?php

namespace Bundles\Category\ModelBundle\Entity;

use Bundles\Category\ModelBundle\Model\ProductInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractClassification
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractClassification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=150)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var ArrayCollection
     */
    private $products;

    /**
     * @var ArrayCollection
     */
    protected $classificationProducts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return CustomCatalog
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add product
     *
     * @param ProductInterface $product
     *
     * @return CustomCatalog
     */
    public function addProduct(ProductInterface $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add classificationProduct
     *
     * @param ClassificationProduct $classificationProduct
     *
     * @return CustomCatalog
     */
    public function addClassificationProduct(
        ClassificationProduct $classificationProduct
    )
    {
        $this->classificationProducts[] = $classificationProduct;

        return $this;
    }

    /**
     * Remove classificationProduct
     *
     * @param ClassificationProduct $classificationProduct
     */
    public function removeClassificationProduct(
        ClassificationProduct $classificationProduct
    )
    {
        $this->classificationProducts->removeElement($classificationProduct);
    }

    /**
     * Get classificationProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassificationProducts()
    {
        return $this->classificationProducts;
    }
}
