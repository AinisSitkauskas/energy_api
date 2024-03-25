<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EnergyMonthlyConsumption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnergyMonthlyConsumption>
 *
 * @method EnergyMonthlyConsumption|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnergyMonthlyConsumption|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnergyMonthlyConsumption[]    findAll()
 * @method EnergyMonthlyConsumption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnergyMonthlyConsumptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnergyMonthlyConsumption::class);
    }
}
