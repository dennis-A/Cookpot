<?php

namespace App\Repository;

use App\Entity\RecipeInfo;
//use App\Entity\RecipeIngredients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Join;
//;Doctrine\ORM\Query\Expr\Join
/**
 * @method RecipeInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeInfo[]    findAll()
 * @method RecipeInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeInfo::class);
    }

    // /**
    //  * @return RecipeInfo[] Returns an array of RecipeInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecipeInfo
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            //->from('App\Entity\RecipeInfo', 'r')
            ->innerJoin('App\Entity\RecipeIngredients', 'ri', 'WITH', 'ri.recipe_id = r.recipe_id')
            //->addSelect('ri')
            ->andWhere("ri.ingredient_name IN ( :val )")
            ->setParameter('val', array_values($value))
            ->orderBy('r.recipe_id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        /*
        return $this->createQueryBuilder('r')
            //->from('App\Entity\RecipeInfo', 'r')
            ->innerJoin('App\Entity\RecipeIngredients', 'ri', 'WITH', 'ri.recipe_id = r.recipe_id')
            ->andWhere('r.recipe_id = :val')
            ->setParameter('val', $value)
            ->orderBy('r.recipe_id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        */
        /*
        return $this->createQueryBuilder('r')
            ->andWhere('r.recipe_id = :val')
            ->setParameter('val', $value)
            ->orderBy('r.recipe_id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        */
    }
}
