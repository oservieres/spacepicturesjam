<?php
namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ChallengeRepository
 */
class ChallengeRepository extends EntityRepository
{

    public function findOneRandomQueued()
    {
        $challengesCount = $this->createQueryBuilder('challenge')
                                ->select('COUNT(challenge)')
                                ->where('challenge.status = :status')
                                ->setParameter('status', 'queued')
                                ->getQuery()
                                ->getSingleScalarResult();

        $randomOffset = rand(0, $challengesCount - 1);

        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'queued')
                    ->getQuery()
                    ->setFirstResult($randomOffset)
                    ->setMaxResults(1)
                    ->getSingleResult();
    }

    public function findAllQueued()
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'queued')
                    ->getQuery()
                    ->getResult();
    }

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
                    ->getOneOrNullResult();
    }

    public function findOneVoting()
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'voting')
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
