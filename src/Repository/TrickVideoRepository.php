<?php

namespace App\Repository;

use App\Entity\TrickVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrickImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickImage[]    findAll()
 * @method TrickImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickVideoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrickVideo::class);
    }
    public function getTrickImage($trickId)
    {
        $re = $this->createQueryBuilder('tt')
            // p.category refers to the "category" property on product
        //    ->innerJoin('t.trickImages', 'ti')
            ->innerJoin('tt.videoList', 'i')
            ->addSelect('i')
            ->andWhere('tt.trickList = :id')
            ->setParameter('id', $trickId)
            ->getQuery()
            //die();
            ->getArrayResult();
     return $re;
//        die();
    }
    // /**
    //  * @return TrickImage[] Returns an array of TrickImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrickImage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
