<?php

namespace Bundles\Product\CoreBundle\Admin;


use Application\Sonata\UserBundle\Entity\User;
use Bundles\Category\ModelBundle\Entity\ClassificationProduct;
use Bundles\Category\ModelBundle\Entity\CustomCatalog;
use Bundles\Category\ModelBundle\Repository\ClassificationProductRepository;
use Bundles\Category\ModelBundle\Repository\CustomCatalogRepository;
use Bundles\Product\ModelBundle\Entity\VendorUser;
use Bundles\Product\ModelBundle\Repository\VendorUserRepository;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Model\ModelManagerInterface;

/**
 * Class ProductAdmin
 */
class ProductAdmin extends Admin
{
    protected $translationDomain = 'ProductCoreBundle';

    /**
     * @param string $context
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /**
         * @var \Doctrine\ORM\QueryBuilder $query
         */
        $query = parent::createQuery($context);

        if (!$this->checkGranted('ROLE_SUPER_ADMIN') && $this->checkGranted('ROLE_SONATA_ADMIN_PRODUCT_EDITOR')) {
            $currentUser = $this->getAuthUser();
            $vendorUserEm = $this->getVendorUserEntityManager();
            $vendorUserRepository = $this->getVendorUserRepository($vendorUserEm);
            /**
             * @var VendorUser $vendorUserEntity
             */
            $vendorUserEntity = $vendorUserRepository->findOneBy([
                'user' => $currentUser
            ]);

            $vendor = $vendorUserEntity->getVendor();

            $query->andWhere($query->getRootAliases()[0].'.vendor = '.$vendor->getId());
        }

        return $query;
    }

    /**
     * Fields to be shown on create/edit forms
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        //@TODO разобраться с переводом лэйблов в sonataadminbundle
        $arrCustomCatalogValues = $this->getArrayOfCustomCategory();

        $formMapper
            ->add('title', 'text', array('label' => 'Название'))
            ->add(
                'vendor', 'entity', array(
                    'class'              => 'Bundles\Product\ModelBundle\Entity\Vendor',
                    'label'              => 'Поставщик',
                )
            )
            ->add(
                'category_id', 'choice', array(
                    'mapped'  => false,
                    'choices' => $arrCustomCatalogValues,
                    'data' => $this->getSelectedCustomCategory(),
                    'label' => 'Родительская категория'
                )
            )
            ->add('description', 'textarea', array('label'=>'Описание'))
            ->add('price', 'number', array('label'=>'Цена в рублях'))
        ;
    }

    /**
     * Fields to be shown on filter forms
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('vendor');
    }

    /**
     * Fields to be shown on lists
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('slug')
            ->add('vendor')
            ->add('price', 'currency', array('currency' => 'RUB'));
    }

    /**
     * @param string $role
     *
     * @return mixed
     */
    private function checkGranted($role)
    {
        return $this->getConfigurationPool()->getContainer()->get('security.context')->isGranted($role);
    }

    /**
     * Get array of values for field with custom categories
     *
     * @return array
     */
    private function getArrayOfCustomCategory()
    {
        /**
         * @var ModelManagerInterface $mm
         */
        $mm = $this->getModelManager();
        $em = $mm->getEntityManager('Bundles\Category\ModelBundle\Entity\CustomCatalog');

        /**
         * @var CustomCatalogRepository $repository
         */
        $repository = $em->getRepository('CategoryModelBundle:CustomCatalog');
        $arrObjects = $repository->findAll();
        $arParent = array();
        /**
         * @var CustomCatalog $objLeaf
         */
        foreach ($arrObjects as $obj) {
            if (null !== $obj->getParent()) {
                $parentId = $obj->getParent()->getId();
                if (!in_array($parentId, $arParent)) {
                    $arParent[] = $obj->getParent()->getId();
                }
            }
        }

        $query = $repository->getAvailableForAddingCategoriesQuery($arParent);
        $arr = $query->getArrayResult();

        return $this->getRightArray($arr);
    }

    /**
     * @param array $arr
     *
     * @return array
     */
    private function getRightArray($arr)
    {
        $rightArray = array();
        if (is_array($arr)) {
            foreach ($arr as $itemCatalog) {
                $rightArray[$itemCatalog['id']] = $itemCatalog['title'];
            }
        }

        return $rightArray;
    }

    /**
     * Get custom category in which is current product
     *
     * @return int|''
     */
    private function getSelectedCustomCategory()
    {
        $product = $this->subject;
        if (null !== $product->getId()) {
            $em = $this->getClassificataionProductEntityManager();
            $repository = $this->getClassificationProductRepository($em);

            /**
             * @var ClassificationProduct $item
             */
            $item = $repository->findOneBy([
                'product' => $product,
                'nmsps' => 'Bundles\Category\ModelBundle\Entity\CustomCatalog'
            ]);

            return $item->getClassification();
        }

        return '';
    }

    /**
     * @param EntityManager $em
     *
     * @return ClassificationProductRepository
     */
    private function getClassificationProductRepository(EntityManager $em)
    {
        /**
         * @var ClassificationProductRepository $repository
         */
        $repository = $em->getRepository('CategoryModelBundle:ClassificationProduct');

        return $repository;
    }

    /**
     * @return EntityManager
     */
    private function getClassificataionProductEntityManager()
    {
        /**
         * @var ModelManagerInterface $mm
         */
        $mm = $this->getModelManager();
        /**
         * @var EntityManager $em
         */
        $em = $mm->getEntityManager('Bundles\Category\ModelBundle\Entity\ClassificationProduct');

        return $em;
    }

    /**
     * @return User
     */
    private function getAuthUser()
    {
        $usr = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();

        return $usr;
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

        $em = $this->getClassificataionProductEntityManager();
        $repository = $this->getClassificationProductRepository($em);

        /**
         * @var ClassificationProduct $item
         */
        $item = $repository->findOneBy([
            'product' => $obj,
            'nmsps' => 'Bundles\Category\ModelBundle\Entity\CustomCatalog'
        ]);
        $item->setClassification($formData['category_id']);
        $em->persist($item);
        $em->flush();
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

        $em = $this->getClassificataionProductEntityManager();
        $repository = $this->getClassificationProductRepository($em);

        /**
         * @var ClassificationProduct $item
         */
        $item = new ClassificationProduct();
        $item->setClassification($formData['category_id']);
        $item->setProduct($obj);
        $item->setNmsps('Bundles\Category\ModelBundle\Entity\CustomCatalog');

        $em->persist($item);
        $em->flush();
    }

    /**
     * @param mixed $obj
     *
     * @return void
     */
    public function preRemove($obj)
    {
        $em = $this->getClassificataionProductEntityManager();
        $repository = $this->getClassificationProductRepository($em);

        $items = $repository->findBy([
            'product' => $obj,
        ]);

        /**
         * @var ClassificationProduct $item
         */
        foreach ($items as $item) {
            $em->remove($item);
        }
        $em->flush();
    }
}