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
                    ->setparameter('status', 'over')
                    ->getQuery()
                    ->getResult();
    }

    public function findOneInprogress()
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setparameter('status', 'inprogress')
                    ->getQuery()
                    ->getSingleResult();
    }
}
