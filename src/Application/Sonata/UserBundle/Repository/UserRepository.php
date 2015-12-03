<?php
/**
 * Created by PhpStorm.
 * User: natali
 * Date: 30.11.15
 * Time: 14:45
 */

namespace Application\Sonata\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class UserRepository
 */
class UserRepository extends EntityRepository
{
    /**
     * Get all users which are not vendor
     *
     * @param array $arrValues
     *
     * @return QueryBuilder
     */
    public function getAvailableForAddingUsersQueryBuilder($arrValues)
    {
        $qb = $this->getQueryBuilder();
        $qb
            ->select('u')
        ;

        if (!empty($arrValues)) {
            $qb->where($qb->expr()->notIn('u.id', $arrValues));
        }

        return $qb;
    }

    /**
     * Get all users which are not vendor
     *
     * @param array $arrValues
     *
     * @return \Doctrine\ORM\Query
     */
    public function getAvailableForAddingUsersQuery($arrValues)
    {
        return $this->getAvailableForAddingUsersQueryBuilder($arrValues)->getQuery();
    }

    /**
     * Get all users which are not vendor
     *
     * @param array $arrValues
     *
     * @return array
     */
    public function getAvailableForAddingUsers($arrValues)
    {
        return $this->getAvailableForAddingUsersQuery($arrValues)->getResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager('ApplicationSonataUserBundle:User');
        $qb = $em->getRepository('ApplicationSonataUserBundle:User')
            ->createQueryBuilder('u');

        return $qb;
    }
}