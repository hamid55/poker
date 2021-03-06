<?php

namespace AppBundle\Repository;

/**
 * PokerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PokerRepository extends \Doctrine\ORM\EntityRepository
{
    public function findPokerWithChoice(string $room)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.room LIKE :room')
            ->andWhere("p.choiceDigit NOT LIKE ''")
            ->setParameter('room', $room)
            ->getQuery()
            ->getResult();
    }
}
