<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return User[] Returns an array of User objects
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

    public function findOneByField($fieldName, $value): ?User
    {
        return $this->createQueryBuilder('t')
            ->andWhere("t.$fieldName,  = :val")
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}