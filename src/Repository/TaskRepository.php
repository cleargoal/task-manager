<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function save(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Task $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Task[] Returns an array of Task objects
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

    public function findOneByField($fieldName, $value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere("t.$fieldName,  = :val")
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
