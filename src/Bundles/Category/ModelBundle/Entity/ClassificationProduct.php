<?php

namespace Bundles\Category\ModelBundle\Entity;

use Bundles\Category\ModelBundle\Model\ProductInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ClassificationProduct
 *
 * @ORM\Table(name="classification_product", uniqueConstraints={
 *      @UniqueConstraint(columns={"product_id", "nmsps"})
 * })
 * @ORM\Entity(repositoryClass="Bundles\Category\ModelBundle\Repository\ClassificationProductRepository")
 */
class ClassificationProduct
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
     * @var ProductInterface
     *
     * @ORM\ManyToOne(targetEntity="Bundles\Category\ModelBundle\Model\ProductInterface")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="classification_id", type="integer", nullable=false)
     */
    private $classification;

    /**
     * @var string
     *
     * @ORM\Column(name="nmsps", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $nmsps;


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
     * Set product
     *
     * @param ProductInterface $product
     *
     * @return ClassificationProduct
     */
    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }



    /**
     * Set namespace
     *
     * @param string $nmsps
     *
     * @return ClassificationProduct
     */
    public function setNmsps($nmsps)
    {
        $this->nmsps = $nmsps;

        return $this;
    }

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNmsps()
    {
        return $this->nmsps;
    }

    /**
     * Set classification
     *
     * @param integer $classification
     *
     * @return ClassificationProduct
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * Get classification
     *
     * @return integer
     */
    public function getClassification()
    {
        return $this->classification;
    }
}
