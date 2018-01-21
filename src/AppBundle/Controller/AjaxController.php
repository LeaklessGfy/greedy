<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AjaxController extends Controller {
    /**
     * @Route("/cities/find/{cp}-{option}", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function findCitiesAction($cp, $option) {
        $em = $this->getDoctrine()->getManager();
        $cities = $em->getRepository('AppBundle:Cities')->findBy(array($option => $cp));

        if($cities) {
            $citiesName = array();
            for($i = 0; $i < count($cities); $i++) {
                array_push($citiesName,array($cities[$i]->getCityNomReel(), $cities[$i]->getCityId()));
            }

            $response = new JsonResponse();
            return $response->setData(array('cities' => $citiesName));
        } else {
            dump('null');
        }
    }

    /**
     * @Route("/cities/delete/{id}", options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function deleteNeedAction($id) {
        $em = $this->getDoctrine()->getManager();
        $needToDelete = $em->getRepository('AppBundle:Needs')->find($id);

        if($needToDelete) {
            if($needToDelete->getOwner() === $this->getUser()) {
                $em->remove($needToDelete);
                $em->flush();

                $this->addFlash('success', 'La need a bien été supprimé');
                return $this->redirectToRoute('activeNeeds');
            } else {
                throw $this->createNotFoundException('Vous n\'avez pas les droits necessaires pour cette action');
            }
        } else {
            throw $this->createNotFoundException('La need demandé n\'existe pas');
        }
    }
}