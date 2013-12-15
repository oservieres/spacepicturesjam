<?php

namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function findByChallenge($challenge)
    {
        return $this->createQueryBuilder('comment')
                    ->where('comment.challenge = :challenge')
                    ->setParameter('challenge', $challenge)
                    ->getQuery()
                    ->getResult();
    }
}
