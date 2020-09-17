<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * @param string $fullName
     *
     * @return Person[]
     */
    public function findWantedByFullName(string $fullName): array
    {
        $qb = $this->createQueryBuilder('person');
        $queryParameters = [
            'isWanted' => true,
            'fullName' => sprintf('%%%s%%', $fullName),
        ];

        return $qb
            ->andHaving($qb->expr()->like('CONCAT(person.firstname, \' \', person.lastname)', ':fullName'))
            ->andWhere('person.isWanted = :isWanted')
            ->setParameters($queryParameters)
            ->orderBy('person.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
