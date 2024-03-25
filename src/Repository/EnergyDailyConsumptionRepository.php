<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EnergyDailyConsumption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EnergyDailyConsumptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnergyDailyConsumption::class);
    }
}
