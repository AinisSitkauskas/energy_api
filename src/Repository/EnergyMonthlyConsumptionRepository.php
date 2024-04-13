<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EnergyMonthlyConsumption;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EnergyMonthlyConsumptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnergyMonthlyConsumption::class);
    }

    public function findLastByUserAndEnergyType(Users $user,int $energyType): ?EnergyMonthlyConsumption
    {
        return $this->createQueryBuilder('emc')
            ->select('emc')
            ->innerJoin('edc.user', 'u')
            ->innerJoin('edc.energyType', 'et')
            ->where('u.id = :userId')
            ->andWhere('et.id = :energyType')
            ->setParameter('userId', $user->getId())
            ->setParameter('energyType', $energyType)
            ->orderBy('emc.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByUserAndEnergyType(Users $user,int $energyType): ?EnergyMonthlyConsumption
    {
        return $this->createQueryBuilder('emc')
            ->select('emc')
            ->innerJoin('edc.user', 'u')
            ->innerJoin('edc.energyType', 'et')
            ->where('u.id = :userId')
            ->andWhere('et.id = :energyType')
            ->setParameter('userId', $user->getId())
            ->setParameter('energyType', $energyType)
            ->orderBy('emc.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
