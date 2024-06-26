<?php

namespace App\Repository;

use App\Entity\ClassCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClassCharacter>
 *
 * @method ClassCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassCharacter[]    findAll()
 * @method ClassCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassCharacter::class);
    }

    public function add(ClassCharacter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ClassCharacter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ClassCharacter[] Returns an array of ClassCharacter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ClassCharacter
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
