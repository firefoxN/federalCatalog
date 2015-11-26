<?php

namespace Bundles\Category\CoreBundle\Controller;

use Bundles\Category\ModelBundle\Repository\ClassificationProductRepository;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class CatalogAdminController
 */
class CatalogAdminController extends Controller
{
    /**
     * @param int|null|string $id
     *
     * @return Response|RedirectResponse
     */
    public function deleteAction($id)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if ($this->getRestMethod() == 'DELETE') {
            $fullClass = get_class($object);
            $nmsps = stristr($fullClass, 'bundles');
            //if we are deleting custom category
            if ($nmsps == 'Bundles\Category\ModelBundle\Entity\CustomCatalog') {
                /**
                 * @var ClassificationProductRepository $classificationProductRepository
                 */
                $classificationProductRepository = $this->get('doctrine')
                    ->getRepository('CategoryModelBundle:ClassificationProduct');

                $items = $classificationProductRepository->findBy(
                    [
                        'classification' => $id,
                        'nmsps' => $nmsps,
                    ]
                );

                if (!empty($items)) {
                    $this->addFlash(
                        'sonata_flash_error',
                        'Данный каталог содержит товары, удаление невозможно. Удалите все товары и повторите попытку.'
                    );

                    $url = $this->admin->generateObjectUrl('edit', $object);

                    return new RedirectResponse($url);
                }
            }

            return parent::deleteAction($id);
        }

        return $this->render(
            $this->admin->getTemplate('delete'), array(
                'object'     => $object,
                'action'     => 'delete',
                'csrf_token' => $this->getCsrfToken('sonata.delete'),
            )
        );
    }
}