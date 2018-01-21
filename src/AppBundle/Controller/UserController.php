<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\FavoritCityType;
use AppBundle\Form\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller {
    /**
     * @Route("/user/me")
     * @Method({"GET", "POST"})
     */
    public function myProfilAction(Request $request) {
        $form = $this->createForm(new PasswordType());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($this->getUser());
            $encodedPassword = $encoder->encodePassword($form['password']->getData(), base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
            $this->getUser()->setPassword($encodedPassword);

            $this->addFlash('success','Votre mot de passe à bien été changé');
            return $this->redirectToRoute('myProfil');
        }
        return $this->render('pages/my-profil.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/user/cities")
     * @Method({"GET", "POST"})
     */
    public function favoritCitiesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new FavoritCityType($em));
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form['city']->getData();
            $this->getUser()->setCity($data);

            $em->persist($this->getUser());
            $em->flush();

            $this->addFlash('success','Votre ville favorite à bien été enregistré');
            return $this->redirectToRoute('favoritCities');
        }

        return $this->render('pages/favorit-cities.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/user/invitations")
     * @Method({"GET", "POST"})
     */
    public function invitFriendsAction(Request $request) {
        $codeLeft = $this->getUser()->getUniCodes(); //Nb de code qu'il reste
        $hideSecurity = true;
        $generatedCode = ""; // ? Code généré

        if($request->getMethod() != 'POST') {
            $codeToGenerate = $this->get('invitations.service')->random(rand(7,15));
            $this->container->get('session')->set("codeToGenerate",$codeToGenerate);
        } else {
            $codeToGenerate = $this->container->get('session')->get("codeToGenerate");
        }

        if($data = $this->get('invitations.service')->handleInvitation($request, $codeLeft, $this->getUser(), $codeToGenerate)) {
            $generatedCode = $data['generatedCode'];
            $codeToGenerate = $data['codeToGenerate'];
            $hideSecurity = $data['hideSecurity'];
        }
        return $this->render('pages/invit-friends.html.twig', array(
            'codeLeft' => $codeLeft,
            'generatedCode' => $generatedCode,
            'codeToGenerate' => $codeToGenerate,
            'hideSecurity' => $hideSecurity
        ));
    }

    /**
     * @Route("/user/{username}")
     * @Method({"GET"})
     */
    public function userProfilAction($username) {
        $em = $this->getDoctrine()->getManager();
        $requestedUser = $em->getRepository('AppBundle:User')->findOneBy(array('username' => $username));

        return $this->render('pages/user-profil.html.twig', array(
            'requestedUser' => $requestedUser
        ));
    }
}