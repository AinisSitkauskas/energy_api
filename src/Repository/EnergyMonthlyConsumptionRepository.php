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

    public function findByUserAndEnergyType(Users $user, int $energyType, int $limit = 1)
    {
        $query = $this->createQueryBuilder('emc')
            ->select('emc')
            ->innerJoin('emc.user', 'u')
            ->innerJoin('emc.energyType', 'et')
            ->where('u.id = :userId')
            ->andWhere('et.id = :energyType')
            ->setParameter('userId', $user->getId())
            ->setParameter('energyType', $energyType)
            ->orderBy('emc.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();

        return $limit > 1 ? $query->getResult() : $query->getOneOrNullResult();
    }
}
