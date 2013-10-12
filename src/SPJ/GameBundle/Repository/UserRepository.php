<?php
namespace SPJ\GameBundle\Repository;

use Doctrine\ORM\EntityRepository;
use \Doctrine\Orm\NoResultException;

class UserRepository extends EntityRepository
{
    public function findOneByEmail($email)
    {
        return $this->createQueryBuilder('user')
                    ->where('user.email = :email')
                    ->setParameter('email', $email)
                    ->getQuery()
                    ->getSingleResult();
    }
}
