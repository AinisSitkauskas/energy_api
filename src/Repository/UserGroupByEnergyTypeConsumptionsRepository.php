<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserGroupByEnergyTypeConsumptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserGroupByEnergyTypeConsumptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroupByEnergyTypeConsumptions::class);
    }

    public function findByUserGroupAndEnergyType(int $userGroup, int $energyType): ?UserGroupByEnergyTypeConsumptions
    {
        return $this->createQueryBuilder('uge')
            ->select('uge')
            ->innerJoin('uge.userGroup', 'ug')
            ->innerJoin('uge.energyType', 'et')
            ->where('ug.id = :userGroupId')
            ->andWhere('et.id = :energyType')
            ->setParameter('userGroupId', $userGroup)
            ->setParameter('energyType', $energyType)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
