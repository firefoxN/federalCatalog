<?php

namespace Bundles\Product\ModelBundle\Entity;

use Application\Sonata\UserBundle\Entity\User;
use Bundles\Product\ModelBundle\Model\VendorInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class VendorUser
 *
 * @ORM\Entity(repositoryClass="Bundles\Product\ModelBundle\Repository\VendorUserRepository")
 * @ORM\Table(name="vendor_user", uniqueConstraints={
 *      @UniqueConstraint(columns={"vendor_id", "user_id"})
 * })
 */
class VendorUser
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var VendorInterface
     *
     * @ORM\ManyToOne(targetEntity="Bundles\Product\ModelBundle\Model\VendorInterface")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $vendor;

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
     * Set user
     *
     * @param User $user
     *
     * @return VendorUser
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set vendor
     *
     * @param Vendor $vendor
     *
     * @return VendorUser
     */
    public function setVendor(Vendor $vendor = null)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get vendor
     *
     * @return Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }
}
