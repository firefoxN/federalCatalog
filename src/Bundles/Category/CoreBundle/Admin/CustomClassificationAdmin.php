<?php

namespace Bundles\Category\CoreBundle\Admin;


use Bundles\Category\ModelBundle\Repository\CustomCatalogRepository;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class CustomClassificationAdmin
 */
class CustomClassificationAdmin extends Admin
{
    protected $maxPerPage = 2500;
    protected $maxPageLinks = 2500;

    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by'    => 'lft',
    );

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

        $query->andWhere($query->getRootAliases()[0].'.parent IS NOT NULL')
            ->orderBy($query->getRootAliases()[0].'.root, '.$query->getRootAliases()[0].'.lft', 'ASC');

        return $query;
    }

    /**
     * Fields to be shown on create/edit forms
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Название категории'))
            ->add(
                'parent', 'entity', array(
                    'class' => 'Bundles\Category\ModelBundle\Entity\CustomCatalog',
                    'label' => 'Родительский элемент'
                )
            );
    }

    /**
     * Fields to be shown on filter forms
     *
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title');
    }

    /**
     * Fields to be shown on lists
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('laveled_title', null, array('sortable' => false, 'label' => 'Заголовок категории'))
            ->add('slug');
    }

    /**
     * @param mixed $object
     *
     * @return void
     */
    public function postPersist($object)
    {
        /**
         * @var EntityManager $em
         */
        $em = $this->modelManager->getEntityManager($object);
        /**
         * @var CustomCatalogRepository $repo
         */
        $repo = $em->getRepository('CategoryModelBundle:CustomCatalog');
        $repo->verify();
        $repo->recover();
        $em->flush();
    }

    /**
     * @param mixed $object
     *
     * @return void
     */
    public function postUpdate($object)
    {
        /**
         * @var EntityManager $em
         */
        $em = $this->modelManager->getEntityManager($object);
        /**
         * @var CustomCatalogRepository $repo
         */
        $repo = $em->getRepository('CategoryModelBundle:CustomCatalog');
        $repo->verify();
        $repo->recover();
        $em->flush();
    }
}