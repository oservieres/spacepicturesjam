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
                    ->join('picture.challenge', 'challenge')
                    ->where('picture.id = :id')
                    ->setParameter('id', $pictureId)
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

    public function addRating($picture, $newRating)
    {
        $this->getEntityManager()->createQuery(
            'UPDATE SPJGameBundle:Picture picture
             SET picture.ratingsAverage = (picture.ratingsCount * picture.ratingsAverage + :new_rating) / (picture.ratingsCount + 1),
                picture.ratingsCount = picture.ratingsCount + 1
             WHERE picture.id = :picture_id')
            ->setParameter('picture_id', $picture->getId())
            ->setParameter('new_rating', $newRating)
            ->execute();
    }
    public function updateRating($picture, $formerRating, $newRating)
    {
         $this->getEntityManager()->createQuery(
            'UPDATE SPJGameBundle:Picture picture
             SET picture.ratingsAverage = ((picture.ratingsCount - 1) * (picture.ratingsAverage - :former_rating) + :new_rating) / picture.ratingsCount
             WHERE picture.id = :picture_id')
            ->setParameter('picture_id', $picture->getId())
            ->setParameter('former_rating', $formerRating)
            ->setParameter('new_rating', $newRating)
            ->execute();
    }
}
