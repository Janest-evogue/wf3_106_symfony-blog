<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param array $filters
     * @return Article[]
     */
    public function search(array $filters = [])
    {
        // constructeur de requête SQL
        // le 'a' est l'alias de l'entité Article
        $qb = $this->createQueryBuilder('a');

        // tri par date publication décroissante
        $qb->orderBy('a.publicationDate', 'DESC');

        if (!empty($filters['title'])) {
            $qb
                ->andWhere('a.title LIKE :title')
                ->setParameter('title', '%' . $filters['title'] . '%')
            ;
        }

        if (!empty($filters['category'])) {
            $qb
                ->andWhere('a.category = :category')
                ->setParameter('category', $filters['category'])
            ;
        }

        if (!empty($filters['start_date'])) {
            $qb
                ->andWhere('a.publicationDate >= :start_date')
                ->setParameter('start_date', $filters['start_date'])
            ;
        }

        if (!empty($filters['end_date'])) {
            $qb
                ->andWhere('a.publicationDate <= :end_date')
                ->setParameter('end_date', $filters['end_date'])
            ;
        }

        if (!empty($filters['with_comments'])) {
            $qb->andWhere('a.comments IS NOT EMPTY');
        }

        // la requête générée
        $query = $qb->getQuery();

        // on retourne le résultat de la requête
        return $query->getResult();
    }
    
    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
