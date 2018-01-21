<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ChatRoomRepository extends EntityRepository
{
    public function getAll($user)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('c')
            ->select('c')
            ->from('AppBundle:ChatRoom', 'c')
            ->where('c.seller = :user OR c.buyer = :user')
            ->setParameter('user', $user)
            ->orderBy('c.lastModification', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getAllFeed($user) {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('c')
            ->select('c')
            ->from('AppBundle:ChatRoom', 'c')
            ->where('c.seller = :user')
            ->setParameter('user', $user)
            ->orderBy('c.lastModification', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getActive($user, $id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('c')
            ->select('c')
            ->from('AppBundle:ChatRoom', 'c')
            ->where('c.seller = :user OR c.buyer = :user')
            ->andWhere('c.id = :chatroomid')
            ->setParameters(array(':user' => $user, ':chatroomid' => $id));

        return $qb->getQuery()->getOneOrNullResult();
    }
}
