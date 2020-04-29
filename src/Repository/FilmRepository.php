<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function setMark($mark, $filmId, $user_id)
    {
    $conn = $this->getEntityManager()->getConnection();

    $query = "
        INSERT INTO markfilmuser (mark, film_id, user_id)
        VALUES ($mark, $filmId, $user_id)";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    }

    public function getTop()
    {
        $conn = $this->getEntityManager()->getConnection();

        $query = "
SELECT AVG(`mark`) as mark, `film_id` FROM `markfilmuser` GROUP BY `film_id` ORDER BY mark limit 10
";

        $stmt = $conn->prepare($query);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    // /**
    //  * @return Film[] Returns an array of Film objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Film
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
