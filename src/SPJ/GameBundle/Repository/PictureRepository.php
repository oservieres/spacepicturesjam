<?php
namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;
use \Doctrine\Orm\NoResultException;

/**
 * PictureRepository
 */
class PictureRepository extends EntityRepository
{
    public function findOneByChallengeAndUser($challenge, $user)
    {
        try {
            return $this->createQueryBuilder('picture')
                        ->where('picture.challenge = :challenge')
                        ->setParameter('challenge', $challenge)
                        ->andWhere('picture.user = :user')
                        ->setParameter('user', $user)
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getSingleResult();
        } catch (NoResultException $exception) {
            return null;
        }
    }
}
