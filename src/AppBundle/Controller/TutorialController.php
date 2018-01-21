<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Needs;
use AppBundle\Entity\Report;
use AppBundle\Form\Type\NeedsType;
use AppBundle\Form\Type\ReportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TutorialController extends Controller {
    public function indexAction(Request $request) {
        $needs = new Needs();

        $em = $this->getDoctrine()->getManager();
        $script = false;

        $formNeeds = $this->createForm(new NeedsType($em), $needs);
        $formNeeds->handleRequest($request);
        if($formNeeds->isValid()) {
            //$response = $this->get('need.service')->handleNeed($formNeeds, $needs, $this->getUser()); A modifier
            if($response) {
                return $this->redirectToRoute('homepage');
            } else {
                $script = true;
            }
        }
        elseif($formNeeds->isSubmitted() && !$formNeeds->isValid()) {
            $this->addFlash('danger', 'Ta création de Need n\'est pas valide :( Corrige la !');
            $script = true;
        }

        return $this->render('tutorial/index.html.twig', array(
            'formNeeds' => $formNeeds->createView(),
            'script' => $script
        ));
    }
}