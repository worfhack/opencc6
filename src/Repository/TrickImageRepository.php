<?php

namespace App\Repository;

use App\Entity\TrickImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrickImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickImage[]    findAll()
 * @method TrickImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrickImage::class);
    }

    public function getTrickImage($trickId)
    {
        $re = $this->createQueryBuilder('tt')

            ->innerJoin('tt.imageList', 'i')
            ->addSelect('i')

            ->andWhere('tt.trickList = :id')
            ->setParameter('id', $trickId)
            ->getQuery()
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