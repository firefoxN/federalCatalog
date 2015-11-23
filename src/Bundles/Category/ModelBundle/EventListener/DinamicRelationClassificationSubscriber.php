<?php
namespace Bundles\Category\ModelBundle\EventListener;


use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;

class DinamicRelationClassificationSubscriber implements EventSubscriber
{
    const CUSTOM_CATALOG_ENTITY_PATH = 'Bundles\Category\ModelBundle\Entity\CustomCatalog';

//    /**
//     * @var string
//     */
//    private $resolveCLass;
//
//    /**
//     * @param string $resolveCLass
//     */
//    public function __construct($resolveCLass)
//    {
//        $this->resolveCLass = $resolveCLass;
//    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
        ];
    }

    /**
     * @param LoadClassMetadataEventArgs $args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        //get class metadata
        /**
         * @var ClassMetadata $metadata
         */
        $metadata = $args->getClassMetadata();



        //reject other classes
        if ($metadata->getName() != self::CUSTOM_CATALOG_ENTITY_PATH) {
            return;
        }

        //Get naming strategy
        $namingStrategy = $args
            ->getEntityManager()
            ->getConfiguration()
            ->getNamingStrategy()
        ;

        //Config the mapping
        $metadata->mapManyToMany(
            [
                'targetEntity' => $this->resolveCLass,
                'joinTable' => [
                    'name' => 'classification_product',
                    'joinColumns' => [
                        [
                            'name' => 'classification_id',
                            'referencedColumnName' => 'id',
                        ]
                    ],
                    'inverseJoinColumns' => [
                        [
                            'name' => 'product_id',
                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
                        ]
                    ]
                ]
            ]
        );
//        $metadata->mapManyToOne(
//            [
//                'targetEntity' => $this->resolveCLass,
//                'fieldName' => 'post',
//                'joinTable' => [
//                    'name' => strtolower($namingStrategy->classToTableName($metadata->getName())),
//                    'joinColumn' => [
//                        [
//                            'name' => $namingStrategy->joinKeyColumnName($metadata->getName()),
//                            'referencedColumnName' => $namingStrategy->referenceColumnName(),
//                            'nullable' => 'false',
//                            'onDelete' => 'CASCADE',
//                        ],
//                    ],
//                ],
//            ]
//        );
    }
}