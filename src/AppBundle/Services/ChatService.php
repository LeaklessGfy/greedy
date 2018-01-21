<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Messages;

class ChatService
{
    public function __construct(EntityManager $em,  Session $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function handleRequest($id, $user)
    {
        $allChatRoom = $this->em->getRepository('AppBundle:ChatRoom')->getAll($user);
        if(!$allChatRoom) {
            return null;
        }

        if(!$id) {
            $id = $allChatRoom[0]->getId();
            $chatRoom = $allChatRoom[0];
        } else {
            $chatRoom = $this->em->getRepository('AppBundle:ChatRoom')->getActive($user, $id);
        }

        if(!$chatRoom) {
            $this->session->getFlashBag()->add('danger', 'Tu ne peux pas acceder à cette conversation');
            return "no access";
        }

        if($chatRoom->getBuyer() == $user) {
            $receiver = $chatRoom->getSeller();
        } else {
            $receiver = $chatRoom->getBuyer();
        }

        return array("allChatRoom" => $allChatRoom, "chatRoom" => $chatRoom, "id" => $id, "receiver" => $receiver);
    }

    public function handleMessage($activeObj, $user) {
        if($activeObj) {
            return new Messages($activeObj, $user, $activeObj->getSeller());
        } else {
            return array();
        }
    }
}
