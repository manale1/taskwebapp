<?php

namespace App\Repository;

use App\Entity\Tache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tache>
 *
 * @method Tache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tache[]    findAll()
 * @method Tache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tache::class);
    }

    public function add(Tache $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tache $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @return Tache[]
     */
    public function findByDate($datedebut,$datefin): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.date_debut <= :dated')
            ->andWhere('t.date_fin >= :datef')
            ->setParameter('dated', $datedebut)
            ->setParameter('datef', $datefin)
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return Tache[]
     */
    public function findByDesignation($designation): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.designation LIKE :design')
            ->setParameter('design','%'.$designation.'%')
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return Tache[]
     */
    public function taskRealized(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id_statut = :idstatut')
            ->setParameter('idstatut',2)
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return Tache[]
     */
    public function taskToBeRealized(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id_statut = :idstatut')
            ->setParameter('idstatut',1)
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return Tache[]
     */
    public function taskClosed(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id_statut = :idstatut OR t.id_statut = :idst')
            ->setParameter('idstatut',3)
            ->setParameter('idst',4)
            ->getQuery()
            ->getResult()
            ;
    }




//    /**
//     * @return Tache[] Returns an array of Tache objects
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

//    public function findOneBySomeField($value): ?Tache
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
