<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    /**
     * @return int|mixed|string
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getMiddleAges()
    {
        return $this->createQueryBuilder('m')
            ->select('avg(DATE_DIFF(CURRENT_DATE(), m.dateOfBirth))')
            ->getQuery()
            ->getSingleScalarResult() / 365
        ;
    }

    /**
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCountMembers(): int
    {
        return $this->createQueryBuilder('m')
            ->select('count(m)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    /**
     * @param Member $team
     * @param bool   $flush
     */
    public function persist(Member $team, bool $flush)
    {
        $this->_em->persist($team);

        if ($flush) {
            $this->_em->flush();
        }
    }
}
