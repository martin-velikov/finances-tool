<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getClassMetadata(User::class));
    }
}
