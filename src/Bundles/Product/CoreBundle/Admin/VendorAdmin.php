<?php

namespace Bundles\Product\CoreBundle\Admin;

use Application\Sonata\UserBundle\Entity\User;
use Application\Sonata\UserBundle\Repository\UserRepository;
use Bundles\Product\ModelBundle\Entity\VendorUser;
use Bundles\Product\ModelBundle\Repository\VendorUserRepository;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Model\ModelManagerInterface;

/**
 * Class VendorAdmin
 */
class VendorAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $arrUsers = $this->getArrayOfFreeUser();
        $formMapper
            ->add('name', 'text', array('label' => 'Название фирмы'))
            ->add('description', 'text', array('label' => 'Описание'))
            ->add(
                'user_id', 'choice', array(
                    'mapped'  => false,
                    'multiple' => true,
                    'choices' => $arrUsers,
                    'data' => $this->getSelectedUsers(),
                    'label' => 'Пользователь',
                )
            )
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('slug')
        ;
    }

    private function getSelectedUsers()
    {
        $vendor = $this->subject;
        $arrValue = array();
        if (null !== $vendor->getId()) {
            $em = $this->getVendorUserEntityManager();
            $repository = $this->getVendorUserRepository($em);

            $items = $repository->findBy([
                'vendor'=>$vendor
            ]);

            /**
             * @var VendorUser $item
             */
            foreach ($items as $item) {
                $arrValue[$item->getUser()->getId()] = $item->getUser()->getId();
            }
        }

        return $arrValue;
    }

    private function getArrayOfFreeUser()
    {
        /**
         * @var ModelManagerInterface $mm
         */
        $mm = $this->getModelManager();

        $emUser = $mm->getEntityManager('Application\Sonata\UserBundle\Entity\User');
        /**
         * @var UserRepository $repositoryUser
         */
        $repositoryUser = $emUser->getRepository('ApplicationSonataUserBundle:User');

        return $this->getRightArrayUsers($repositoryUser->findAll());
    }

    private function getRightArrayUsers($arr)
    {
        $rightArray = array();
        if (is_array($arr)) {
            /**
             * @var User $itemUser
             */
            foreach ($arr as $itemUser) {
                $rightArray[$itemUser->getId()] = $itemUser->getUsername().' | '. $itemUser->getLastname().' '.$itemUser->getFirstname();
            }
        }

        return $rightArray;
    }

    /**
     * @param EntityManager $em
     *
     * @return VendorUserRepository
     */
    private function getVendorUserRepository(EntityManager $em)
    {
        /**
         * @var VendorUserRepository $repository
         */
        $repository = $em->getRepository('ProductModelBundle:VendorUser');

        return $repository;
    }

    /**
     * @return EntityManager
     */
    private function getVendorUserEntityManager()
    {
        /**
         * @var ModelManagerInterface $mm
         */
        $mm = $this->getModelManager();
        /**
         * @var EntityManager $em
         */
        $em = $mm->getEntityManager('Bundles\Product\ModelBundle\Entity\VendorUser');

        return $em;
    }

    /**
     * @return EntityManager
     */
    private function getVendorEntityManager()
    {
        /**
         * @var ModelManagerInterface $mm
         */
        $mm = $this->getModelManager();
        /**
         * @var EntityManager $em
         */
        $em = $mm->getEntityManager('Bundles\Product\ModelBundle\Entity\Vendor');

        return $em;
    }

    /**
     * @param EntityManager $em
     *
     * @return UserRepository
     */
    private function getUserRepository(EntityManager $em)
    {
        /**
         * @var UserRepository $repository
         */
        $repository = $em->getRepository('ApplicationSonataUserBundle:User');

        return $repository;
    }

    /**
     * @return EntityManager
     */
    private function getUserEntityManager()
    {
        /**
         * @var ModelManagerInterface $mm
         */
        $mm = $this->getModelManager();
        /**
         * @var EntityManager $em
         */
        $em = $mm->getEntityManager('Application\Sonata\UserBundle\Entity\User');

        return $em;
    }

    /**
     * for edited object
     *
     * @param mixed $obj
     *
     * @return void
     */
    public function postUpdate($obj)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        $em = $this->getVendorUserEntityManager();
        $repository = $this->getVendorUserRepository($em);

        $items = $repository->findBy([
            'vendor'=>$obj
        ]);

        $vendorEm = $this->getVendorEntityManager();
        //deleting all connections between vendors and users
        foreach ($items as $vendor) {
            $vendorEm->remove($vendor);
        }
        $vendorEm->flush();

        //create new connections between vendors and users
        $userEm = $this->getUserEntityManager();
        $userRepository = $this->getUserRepository($userEm);

        if (!empty($formData['user_id'])) {
            foreach ($formData['user_id'] as $userId) {
                $user = $userRepository->find($userId);
                $item = new VendorUser();
                $item->setVendor($obj);
                $item->setUser($user);
                $vendorEm->persist($item);
            }
            $vendorEm->flush();
        }
    }

    /**
     * for new object
     *
     * @param mixed $obj
     *
     * @return void
     */
    public function postPersist($obj)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        //create new connections between vendors and users
        $userEm = $this->getUserEntityManager();
        $userRepository = $this->getUserRepository($userEm);

        $vendorEm = $this->getVendorEntityManager();
        if (!empty($formData['user_id'])) {
            foreach ($formData['user_id'] as $userId) {
                $user = $userRepository->find($userId);
                $item = new VendorUser();
                $item->setVendor($obj);
                $item->setUser($user);
                $vendorEm->persist($item);
            }
            $vendorEm->flush();
        }
    }

    /**
     * @param mixed $obj
     *
     * @return void
     */
    public function preRemove($obj)
    {
        $em = $this->getVendorUserEntityManager();
        $repository = $this->getVendorUserRepository($em);

        $items = $repository->findBy([
            'vendor'=>$obj
        ]);

        /**
         * @var VendorUser $item
         */
        foreach ($items as $item) {
            $em->remove($item);
        }
        $em->flush();
    }
}