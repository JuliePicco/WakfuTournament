<?php

namespace App\Repository;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    

    // ! a voir demain
    //* fonction permettant de retrouver un leader enregistrer dans un tournois

    public function findregistered($user_id){

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        // Requete permettant de cherche les équipes du leader/user
        $qb = $sub;
        $qb->select('t')
            ->from('App\Entity\Team', 't')
            ->leftJoin('t.tournaments', 'to')
            ->where('t.leader = :id');

        $sub = $em->createQueryBuilder();

        // Sous requete pour obtenir les équipes inscrite du leader
            $sub->select('te')
            ->from('App\Entity\Team', 'te')
            ->leftJoin('to.tournaments', 'to')
            ->andWhere($sub->expr()->notIn('te.id', $qb->getDQL()))
            ->setParameter('id', $user_id);
         

        $query = $sub->getQuery();
        return $query->getResult();
    }

// SELECT t.leader_id, t.team_name, u.pseudonyme
// FROM team t
// INNER JOIN user u
// ON t.leader_id = u.id
// WHERE t.id IN (
// 	SELECT tt.team_id
// 	FROM tournament_team tt
// 	INNER JOIN tournament tr
// 	ON tt.tournament_id = tr.id
// 	WHERE tr.id = 1
// )





//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
