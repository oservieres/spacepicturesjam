<?php

namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RatingRepository extends EntityRepository
{
    public function findOneByUserAndPicture($user, $picture)
    {
        return $this->createQueryBuilder('rating')
                    ->where('rating.user = :user')
                    ->setParameter('user', $user)
                    ->andWhere('rating.picture = :picture')
                    ->setParameter('picture', $picture)
                    ->getQuery()
                    ->getSingleResult();
    }

    public function findSummary($picture, $user) {
        $statistics = $this->getEntityManager()->createQuery(
            'SELECT AVG(rating.value), COUNT(rating.value)
            FROM SPJGameBundle:Rating rating
            WHERE rating.picture = :picture')
            ->setParameter('picture', $picture)
            ->getScalarResult();

        $userRating = null;
        if (null !== $user) {
            $userRating = $this->createQueryBuilder('rating')
                    ->where('rating.picture = :picture')
                    ->setParameter('picture', $picture)
                    ->andWhere('rating.user = :user')
                    ->setParameter('user', $user)
                    ->getQuery()
                    ->getOneOrNullResult();
        }

        return array(
            'average' => $statistics[0][1],
            'sum' => $statistics[0][2],
            'userRating' => $userRating
        );
    }
}
