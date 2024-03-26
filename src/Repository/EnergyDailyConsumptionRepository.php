<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EnergyDailyConsumption;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EnergyDailyConsumptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnergyDailyConsumption::class);
    }

    public function findUserConsumptionBetweenDates(Users $user, \DateTime $dateFrom, \DateTime $dateTo): array
    {
        return $this->createQueryBuilder('emc')
            ->select('emc', 'u', 'et')
            ->innerJoin('emc.user', 'u')
            ->innerJoin('emc.energyTpe', 'et')
            ->where('u.id = :userId')
            ->andWhere('emc.createdAt > :dateFrom')
            ->andWhere('emc.createdAt < :dateTo')
            ->setParameter('userId', $user->getId())
            ->setParameter('dateFrom', $dateFrom->format('Y-m-d H:i:s'))
            ->setParameter('dateTo', $dateTo->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();
    }
}
