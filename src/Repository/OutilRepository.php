<?php

namespace App\Repository;

use App\Entity\Outil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Outil>
 *
 * @method Outil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Outil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Outil[]    findAll()
 * @method Outil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Outil::class);
    }

    public function add(Outil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Outil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function JsonToFormHtml($json)
    {
        $Json = json_decode($json, true);
        $form = '';
        //var_dump($form);
        foreach ($Json as $j) {
            $type = $j["type"];
            if ($type == "text") {
                $form = '<p>'.$form.$j["name"].'</p><input  class="input" type="text"  name="'.$j["id"].'" id="'.$j["id"].'"><br>'. PHP_EOL;
            } elseif ($type == "textarea") {
                $form = '<p>'.$form.$j["name"].'</p><textarea  class="input"   name="'.$j["id"].'" id="'.$j["id"].'"></textarea><br>'. PHP_EOL;
            } elseif ($type == "select") {
                $val = '<option value="">--Please choose an option--</option>'.PHP_EOL;
                foreach ($j['values'] as $v) {
                    $val = $val . '<option  value="'.$v.'" >'.$v.'</option>'. PHP_EOL;
                }
                $form = '<p>'.$form.$j["name"].'</p><div class="select" ><select name="'.$j["id"].'"  id="'.$j["id"].'">'.PHP_EOL.$val.'</select></div><br>'. PHP_EOL;
            } elseif ($type == "radio") {
                $form = '<p>'.$form.$j["name"].'</p><input type="radio" name="'.$j["id"].'" id="'.$j["id"].'" ><br>'. PHP_EOL;
            }
            elseif ($type == "date") {
                $form = '<p>'.$form.$j["name"].'</p><input name="'.$j["id"].'" class="input" type="date" id="'.$j["id"].'"><br>'. PHP_EOL;
            }
            elseif ($type == "checkbox") {
                $form = '<p>'.$form.$j["name"].'</p><input  name="'.$j["id"].'" type="checkbox" id="'.$j["id"].'"><br>'. PHP_EOL;
            }
        }
        return $form;
    }

//    /**
//     * @return Outil[] Returns an array of Outil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Outil
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
