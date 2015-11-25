<?php

namespace Bundles\Category\ModelBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CustomCatalog
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="customCatalog")
 * use repository for handy tree functions
 * @ORM\Entity(repositoryClass="Bundles\Category\ModelBundle\Repository\CustomCatalogRepository")
 */
class CustomCatalog extends AbstractClassification
{
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"}, unique=true)
     * @ORM\Column(length=255)
     */
    private $slug;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="customCatalog", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="customCatalog", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return CustomCatalog
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return CustomCatalog
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return CustomCatalog
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return CustomCatalog
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     *
     * @return CustomCatalog
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param customCatalog $parent
     *
     * @return CustomCatalog
     */
    public function setParent(customCatalog $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return customCatalog
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param customCatalog $child
     *
     * @return CustomCatalog
     */
    public function addChild(customCatalog $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param customCatalog $child
     */
    public function removeChild(customCatalog $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $prefix = '';
        for ($i=2; $i<= $this->lvl; $i++) {
            $prefix .= '--';
        }

        return $prefix.$this->getTitle() ;
    }

    /**
     * @return string
     */
    public function getLaveledTitle()
    {
        return (string) $this;
    }
}
