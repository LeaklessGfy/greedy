<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ChatRoom;
use AppBundle\Entity\Report;
use AppBundle\Form\Type\MessagesType;
use AppBundle\Form\Type\ReportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ChatController extends Controller
{
    /**
     * @Route("need/feed/{id}", requirements={"id" = "\d+"})
     * @Method({"GET"})
     */
    public function feedNeedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $need = $em->getRepository('AppBundle:Needs')->find($id);

        if($need) {
            $alreadyChatRoom = $em->getRepository('AppBundle:ChatRoom')->findOneBy(array('need' => $need, 'seller' => $this->getUser()));
            if($alreadyChatRoom) {
                return $this->redirectToRoute('chatRoom', array('chatroomid' => $alreadyChatRoom->getId()), 301);
            } else {
                $endDate = new \DateTime($need->getEndDate()->format('y-m-d'));
                $today = new \DateTime();
                if($today->format('Y-m-d') < $endDate->format('Y-m-d')) {
                    if($need->getOwner() === $this->getUser()) {
                        $this->addFlash('danger', 'Tu ne peux pas feed t\'as propre Need');
                        return $this->redirectToRoute('homepage');
                    } else {
                        $chatRoom = new ChatRoom();

                        $chatRoom->setNeed($need);
                        $chatRoom->setBuyer($need->getOwner());
                        $chatRoom->setSeller($this->getUser());
                        $chatRoom->setLastModification(new \DateTime());

                        $em->persist($chatRoom);
                        $em->flush();

                        return $this->redirectToRoute('chatRoom', array('chatroomid' => $chatRoom->getId()),301);
                    }
                } else {
                    $this->addFlash('danger', 'Tu ne peux plus feed cette need car sa date limite est dépassé');
                    return $this->redirectToRoute('homepage');
                }
            }
        } else {
            $this->addFlash('danger', 'La need que tu cherches à feed n\'existe pas ou plus');
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/need/chatroom-xdddx/{id}", requirements={"id" = "\d+"})
     * @Method({"GET", "POST"})
     */
    public function chatRoomAction($id = null, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dataGranted = $this->get('chat_room.service')->handleRequest($id, $this->getUser());

        if(!$dataGranted) {
            return $this->render('pages/chat-room-empty.html.twig');
        } elseif($dataGranted === "no access") {
            return $this->redirectToRoute('app_chat_chatroom');
        }

        $allChatRoom    = $dataGranted['allChatRoom'];
        $chatRoom       = $dataGranted['chatRoom'];
        $id             = $dataGranted['id'];
        $receiver       = $dataGranted['receiver'];

        $report = new Report();
        $message = new Messages($chatRoom, $this->getUser(), $receiver);

        $formMessage = $this->createForm(new MessagesType(), $message);
        $formReport = $this->createForm(new ReportType(), $report, array(
            'action' => $this->generateUrl('reportByChat'),
            'method' => 'POST'
        ));

        $formMessage->handleRequest($request);
        if($formMessage->isSubmitted() && $formMessage->isValid()) {
            $chatRoom->setLastModification(new \DateTime('now'));
            $em->persist($message);
            $em->persist($chatRoom);
            $em->flush();

            return $this->redirectToRoute('app_chat_chatroom', array('id' => $id),301);
        }

        return $this->render('pages/chat-room.html.twig', array(
            'chatRoom' => $chatRoom,
            'formMessage' => $formMessage->createView(),
            'formReport' => $formReport->createView(),
            'allChatRoom' => $allChatRoom
        ));
    }

    /**
     * @Route("/chatroom/need/{id}", requirements={"id" = "\d+"})
     * @Method({"GET", "POST"})
     */
    public function chatNeed($id = null, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $allNeeds = $em->getRepository('AppBundle:Needs')->findBy(array("owner" => $this->getUser()));

        $activeNeed = null;
        $stopHidden = null;
        foreach($allNeeds as $need) {
            foreach($need->getChatRoom() as $chatRoom) {
                if($chatRoom->getId() == $id) {
                    $activeNeed = $chatRoom;
                    $stopHidden = $need->getId();
                }
            }
        }

        $message = $this->get('chat_room.service')->handleMessage($activeNeed, $this->getUser());

        $formMessage = $this->createForm(new MessagesType(), $message);
        $formMessage->handleRequest($request);
        if($formMessage->isSubmitted() && $formMessage->isValid()) {
            $activeNeed->setLastModification(new \DateTime('now'));
            $em->persist($message);
            $em->persist($activeNeed);
            $em->flush();

            return $this->redirectToRoute('app_chat_chatneed', array('id' => $id),301);
        }

        return $this->render('pages/chat-need.html.twig', array(
            'allNeeds' => $allNeeds,
            'activeObj' => $activeNeed,
            'stopHidden' => $stopHidden,
            'formMessage' => $formMessage->createView()
        ));
    }

    /**
     * @Route("/chatroom/feed/{id}", requirements={"id" = "\d+"})
     * @Method({"GET", "POST"})
     */
    public function chatFeed($id = null, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $allFeeds = $em->getRepository('AppBundle:ChatRoom')->getAllFeed($this->getUser());

        $activeFeed = null;
        foreach($allFeeds as $feed) {
            if($feed->getId() == $id) {
                $activeFeed = $feed;
            }
        }

        $message = $this->get('chat_room.service')->handleMessage($activeFeed, $this->getUser());

        $formMessage = $this->createForm(new MessagesType(), $message);
        $formMessage->handleRequest($request);
        if($formMessage->isSubmitted() && $formMessage->isValid()) {
            $activeFeed->setLastModification(new \DateTime('now'));
            $em->persist($message);
            $em->persist($activeFeed);
            $em->flush();

            return $this->redirectToRoute('app_chat_chatfeed', array('id' => $id),301);
        }

        return $this->render('pages/chat-feed.html.twig', array(
            'allFeeds' => $allFeeds,
            'activeObj' => $activeFeed,
            'formMessage' => $formMessage->createView()
        ));
    }
}
