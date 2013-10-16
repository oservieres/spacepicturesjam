<?php
namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;
use \Doctrine\Orm\NoResultException;

/**
 * PictureRepository
 */
class PictureRepository extends EntityRepository
{
    public function findOneById($pictureId)
    {
        return $this->createQueryBuilder('picture')
                    ->leftJoin('picture.comments', 'comments')
                    ->join('picture.user', 'user')
                    ->where('picture.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function findOneByChallengeAndUser($challenge, $user)
    {
        return $this->createQueryBuilder('picture')
                    ->where('picture.challenge = :challenge')
                    ->setParameter('challenge', $challenge)
                    ->andWhere('picture.user = :user')
                    ->setParameter('user', $user)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
