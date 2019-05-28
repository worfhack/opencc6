<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trick::class);
    }
    public function getHightPosition()
    {
        $query = $this->createQueryBuilder('t');
        $query->select('MAX(t.position) AS max_position');
        return $query->getQuery()->getSingleScalarResult();
    }
    public function getTricks($first_result, $max_results = 5)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->select('t')
            ->join("t.trickImages", 'i')
            ->orderBy('t.position', 'ASC')
            ->where('i.thumbnail =  1')
            ->setFirstResult($first_result)
            ->setMaxResults($max_results);

        $pag = new Paginator($qb);
        return $pag;
    }


    public function cleanPosition($old_position, $new_position)
    {

        $qb = $this->createQueryBuilder("t");
        $q = $qb->update(Trick::class, 't')
            ->set('t.position', 't.position ' .  ($new_position < $old_position ? ' + 1' : -1 ))
            ->where( ($new_position < $old_position ?
                    ' t.position >= :new_position AND t.position < :old_position '
                : 't.position <= :new_position  AND t.position > :old_position' ))
            ->setParameter('old_position', $old_position)
            ->setParameter('new_position', $new_position)
            ->getQuery();
        $p = $q->execute();
//        if ($old_position < $new_position)
//        {
//            $sql  = "UPDATE trick SET position = position+1 WHERE position >= :new_position AND position < :old_position ";
//
//        }else{
//            $sq = "UPDATE trick SET position = position-1 WHERE position <= :new_position  AND position > :old_position ";
//
//        }
        //$this->getEntityManager()

    }


}
