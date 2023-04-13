<?php

namespace App\Repository;

use App\Entity\FruitNutrition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FruitNutrition>
 *
 * @method FruitNutrition|null find($id, $lockMode = null, $lockVersion = null)
 * @method FruitNutrition|null findOneBy(array $criteria, array $orderBy = null)
 * @method FruitNutrition[]    findAll()
 * @method FruitNutrition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitNutritionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FruitNutrition::class);
    }

    public function save(FruitNutrition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FruitNutrition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FruitNutrion[] Returns an array of FruitNutrion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FruitNutrion
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
