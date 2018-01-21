<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Needs;
use AppBundle\Entity\Report;
use AppBundle\Form\Type\NeedsType;
use AppBundle\Form\Type\ReportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends Controller
{
    /**
     * @Route("/")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $allNeeds = $em->getRepository('AppBundle:Needs')->findBy(array(), array('id' => 'DESC'));

        $needs = new Needs($this->getUser());
        $formNeeds = $this->createForm(new NeedsType($em), $needs);
        $formNeeds->handleRequest($request);
        if($formNeeds->isValid()) {
            $this->get('need.service')->handleNeed($formNeeds, $needs);
            return $this->redirectToRoute('homepage');
        }
        elseif($formNeeds->isSubmitted() && !$formNeeds->isValid()) {
            $this->addFlash('danger', 'Ta Need n\'est pas valide. Corrige la !');
        }

        return $this->render('pages/index.html.twig', array(
            'formNeeds' => $formNeeds->createView(),
            'allNeeds' => $allNeeds
        ));
    }

    /**
     * @Route("/need/actives")
     * @Method({"GET", "POST"})
     */
    public function activeNeedsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $allNeeds = $em->getRepository('AppBundle:Needs')->findBy(array('owner' => $this->getUser()), array('id' => 'DESC'));

        return $this->render('pages/active-needs.html.twig', array(
            'allNeeds' => $allNeeds
        ));
    }
}
