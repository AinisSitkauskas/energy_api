<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserGroupEnergyConsumption;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserGroupEnergyConsumptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroupEnergyConsumption::class);
    }

    public function findUserGroupConsumptions(Users $user): array
    {
        return $this->createQueryBuilder('ugc')
            ->select('ugc')
            ->innerJoin('ugc.userGroup', 'ug')
            ->where('ug.id = :userGroupId')
            ->setParameter('userGroupId', $user->getUserInformation()->getUserGroup()->getId())
            ->orderBy('ugc.averageConsumption', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
