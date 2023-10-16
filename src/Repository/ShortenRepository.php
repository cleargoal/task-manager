<?php

namespace App\Repository;

use App\Entity\Shorten;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\ByteString;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @extends ServiceEntityRepository<Shorten>
 *
 * @method Shorten|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shorten|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shorten[]    findAll()
 * @method Shorten[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortenRepository extends ServiceEntityRepository
{
    protected ValidatorInterface $validator;

    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        parent::__construct($registry, Shorten::class);
        $this->validator = $validator;
    }

    public function save(Shorten $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Shorten $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Find Entity containing entered URL
     *
     * @param $value
     *
     * @return Shorten[] Returns an array of Shorten objects
     */
    private function findBySourceUrl($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.source_url = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find Entity containing entered URL
     *
     * @param $value
     *
     * @return Shorten[] Returns an array of Shorten objects
     */
    private function findByHashedUrl($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.hashed_url = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    /**
     * Shorten operations
     *
     * @param $sourceUrl
     * @param $host
     *
     * @return array
     */
    public function shorten($sourceUrl, $host): array
    {
        $shorter = new Shorten();

        $shorter->setSourceUrl($sourceUrl);
        $shorter->setHashedUrl('just stub'); // it's because the Validator doesn't check a separate field
        $errors = $this->validator->validate($shorter);

        if (count($errors) > 0) {
            $response = [
                'message' => (string)$errors[0]->getMessage(),
                'field' => $errors[0]->getPropertyPath(),
                'code' => '400',
            ];
        } else {
            $existSource = $this->findBySourceUrl($sourceUrl);
            $uri = '/api/revert/';

            if ($existSource) {
                $source = $existSource[0]->getSourceUrl();
                $hash = $existSource[0]->getHashedUrl();
                $response = [
                    'This URL already has been shortened' => [
                        $source,
                        $hash,
                        $host . $uri . $hash,
                    ],
                ];
            } else {
                do {
                    $hashedUrl = ByteString::fromRandom(6)->toString();
                    $foundHash = $this->searchForHash($hashedUrl);

                    if (!$foundHash) {
                        $shorter->setHashedUrl($hashedUrl);
                        $this->save($shorter, true);
                    }
                } while ($foundHash);

                $response = [
                    'Original URL is: ' => $sourceUrl,
                    'The short URL is: ' => $host . $uri . $hashedUrl,
                ];
            }
        }
        return $response;
    }

    /**
     * Check if Unique hash generated
     */
    private function searchForHash($value)
    {
        return $this->createQueryBuilder('q')
            ->where('q.hashed_url = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    /**
     * Shorten operations
     *
     * @param $shortened
     * @param $host
     *
     * @return array
     */
    public function revert($shortened, $host): array
    {
        $shorter = new Shorten();

        $shorter->setSourceUrl('just stub'); // it's because the Validator doesn't check a separate field
        $shorter->setHashedUrl($shortened);
        $errors = $this->validator->validate($shorter);

        if (count($errors) > 0) {
            $response = [
                'message' => (string)$errors[0]->getMessage(),
                'field' => $errors[0]->getPropertyPath(),
                'code' => '400',
            ];
        }else {
            $existHashed = $this->findByHashedUrl($shortened);
            $uri = '/api/revert/';

            if (!$existHashed) {
                $response = [
                    "message" => 'Shortened URL not found. Please, check URL you entered.',
                    "entered URL" => $host . $uri . $shortened,
                    "code" => '404',
                ];
            }
            else {
                $source = $existHashed[0]->getSourceUrl();
                $response = [
                    'The entered URL is: ' => $host . $uri . $shortened,
                    'Original URL is: ' => $source,
                ];
            }
        }

        return $response;
    }
}
