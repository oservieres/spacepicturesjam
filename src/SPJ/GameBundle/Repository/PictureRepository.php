<?php
namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;
use \Doctrine\Orm\NoResultException;

/**
 * PictureRepository
 */
class PictureRepository extends EntityRepository
{

    public function findByChallenge($challenge)
    {
        $queryBuilder = $this->createQueryBuilder('picture')
                             ->join('picture.user', 'user')
                             ->where('picture.challenge = :challenge')
                             ->setParameter('challenge', $challenge);

        if ("over" === $challenge->getStatus()) {
            $queryBuilder->addOrderBy('picture.ratingsAverage', 'DESC')
                         ->addOrderBy('picture.ratingsCount', 'DESC')
                         ->setMaxResults(3);
        }

        return $queryBuilder->getQuery()
                            ->getResult();
    }

    public function findOneBeside($picture, $isNext)
    {
        return $this->createQueryBuilder('picture')
                    ->leftJoin('picture.comments', 'comments')
                    ->join('picture.user', 'user')
                    ->join('picture.challenge', 'challenge')
                    ->where('picture.challenge = :challenge')
                    ->setParameter('challenge', $picture->getChallenge())
                    ->andWhere('picture.id ' . ($isNext ? '>' : '<') . ' :id')
                    ->setParameter('id', $picture->getId())
                    ->orderBy('picture.id', $isNext ? 'ASC' : 'DESC')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    public function findOnePrevious($picture)
    {
        return $this->findOneBeside($picture, false);
    }

    public function findOneNext($picture)
    {
        return $this->findOneBeside($picture, true);
    }

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
             SET picture.ratingsAverage = (picture.ratingsCount * picture.ratingsAverage - :former_rating + :new_rating) / picture.ratingsCount
             WHERE picture.id = :picture_id')
            ->setParameter('picture_id', $picture->getId())
            ->setParameter('former_rating', $formerRating)
            ->setParameter('new_rating', $newRating)
            ->execute();
    }

    public function findCountByChallenge($challenge)
    {
        return $this->createQueryBuilder('picture')
                    ->select('COUNT(picture)')
                    ->where('picture.challenge = :challenge')
                    ->setParameter('challenge', $challenge)
                    ->getQuery()
                    ->getSingleScalarResult();
    }
}
