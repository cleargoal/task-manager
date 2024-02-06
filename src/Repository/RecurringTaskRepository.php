<?php

namespace App\Repository;

use App\Entity\RecurringTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecurringTask>
 *
 * @method RecurringTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecurringTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecurringTask[]    findAll()
 * @method RecurringTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecurringTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecurringTask::class);
    }

    public function save(RecurringTask $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RecurringTask $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return RecurringTask[] Returns an array of RecurringTask objects
     */
    public function findByField($fieldName, $value, $maxResults = 10, $order = 'ASC'): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere("t.$fieldName,  = :val")
            ->setParameter('val', $value)
            ->orderBy('t.id', $order)
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }

    public function findOneByField($fieldName, $value): ?RecurringTask
    {
        return $this->createQueryBuilder('t')
            ->andWhere("t.$fieldName,  = :val")
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
