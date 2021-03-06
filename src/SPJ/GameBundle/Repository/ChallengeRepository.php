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

    public function findAllOver($limit = 5)
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'over')
                    ->orderBy('challenge.endVotingDate', 'DESC')
                    ->getQuery()
                    ->setMaxResults($limit)
                    ->getResult();
    }

    public function findOneLatestOver()
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'over')
                    ->orderBy('challenge.id', 'DESC')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function findOneInprogress()
    {
        return $this->createQueryBuilder('challenge')
                    ->where('challenge.status = :status')
                    ->setParameter('status', 'inprogress')
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
