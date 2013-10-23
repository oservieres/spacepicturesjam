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
}
