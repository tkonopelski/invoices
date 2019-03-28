<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invoice::class);
    }


    public function findByUser($user)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.client= :client')
            ->setParameter('client', $user)
            ->orderBy('i.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    // TODO!
    public function findOneByUser($user): ?Invoice
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.client= :client')
            ->setParameter('client', $user)

            ->getQuery()
            ->getOneOrNullResult()
            ;
    }





}
