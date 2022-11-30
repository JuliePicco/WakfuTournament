<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function add(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // ! REQUETES DQL PERSONNALISEES

    //* Fonction qui permet de trouver les équipes auxquel le User n'apparait pas
    
    public function findTeamsWhereImNotIn($user_id){

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        // Requete permettant de chercher les équipes d'un user
        $qb = $sub;
        $qb->select('t')
            ->from('App\Entity\Team', 't')
            ->leftJoin('t.members', 'u')
            ->where('u.id = :id');
            

        $sub = $em->createQueryBuilder();

        //  sous requete donnant les équipes auxquel un user n'appartient pas 
            $sub->select('te')
            ->from('App\Entity\Team', 'te')
            ->where($sub->expr()->notIn('te.id', $qb->getDQL()))
            ->setParameter('id', $user_id);
    

        $query = $sub->getQuery();
        return $query->getResult();

    }

      // ! FIN DES REQUETES DQL PERSONNALISEES


    //* Fonction  qui permet de trouver les joueurs qui ne sont pas dans l'équipe
    
    public function findNotMembers($team_id){

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        // Requete permettant de chercher les user dans l'équipe
        $qb = $sub;
        $qb->select('u')
            ->from('App\Entity\User', 'u')
            ->leftJoin('u.teams', 't')
            ->where('t.id = :id');
            

        $sub = $em->createQueryBuilder();

        //  sous requete donnant les users qui ne sont pas dans une équipe
            $sub->select('us')
            ->from('App\Entity\User', 'us')
            ->where($sub->expr()->notIn('us.id', $qb->getDQL()))
            ->setParameter('id', $team_id)
            ->orderBy('us.pseudonyme', 'ASC');
    

        $query = $sub->getQuery();
        return $query->getResult();

    }





    //   todo requete sql test
    //   SELECT u.pseudonyme, s.server_name
    //   FROM server s
    //   INNER JOIN team t
    //   ON t.server_id = s.id
    //   INNER JOIN user_team ut
    //   ON t.id = ut.team_id
    //   INNER JOIN user u
    //   ON ut.user_id = u.id
    //   WHERE u.id = 1 





    

//    /**
//     * @return Team[] Returns an array of Team objects
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

//    public function findOneBySomeField($value): ?Team
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
