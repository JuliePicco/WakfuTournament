<?php

namespace App\Repository;

use App\Entity\Tournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournament>
 *
 * @method Tournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournament[]    findAll()
 * @method Tournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    public function add(Tournament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tournament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



    //* Fonction  permettant de trouver les teams non inscrit
    
    public function findUnregistered($tournament_id){

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        // Requete permettant de cherche les teams inscrits dans un tournois
        $qb = $sub;
        $qb->select('t')
            ->from('App\Entity\Team', 't')
            ->leftJoin('t.tournaments', 'to')
            ->where('to.id = :id');
            

        $sub = $em->createQueryBuilder();

        // Sous requete regroupant toutes les teams existantes en les soustrayants aux resultat de la requete précédante pour obtenir les teams non inscrit
            $sub->select('te')
            ->from('App\Entity\Team', 'te')
            ->where($sub->expr()->notIn('te.id', $qb->getDQL()))
            ->setParameter('id', $tournament_id)
            ->orderBy('te.teamName', 'ASC');

        $query = $sub->getQuery();
        return $query->getResult();

    }

//    /**
//     * @return Tournament[] Returns an array of Tournament objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Tournament
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
