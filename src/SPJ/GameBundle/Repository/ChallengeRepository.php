<?php
namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ChallengeRepository
 */
class ChallengeRepository extends EntityRepository
{
    public function findAllOver()
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'over')
                    ->getQuery()
                    ->getResult();
    }

    public function findOneInprogress()
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'inprogress')
                    ->getQuery()
                    ->getSingleResult();
    }
}
