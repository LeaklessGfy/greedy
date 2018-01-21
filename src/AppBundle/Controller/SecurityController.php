<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class SecurityController extends Controller {
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createForm(new RegisterType(), $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $encodedPassword = $encoder->encodePassword($user->getPassword(), base_convert(sha1(uniqid(mt_rand(), true)), 16,
                36));
            $user->setPassword($encodedPassword);

            $user->setEReputation(0);

            $unicode = $em->getRepository('AppBundle:UniCode')->findOneBy(array('code' => $user->getUniCode()));
            $unicode->setAvailable(0);

            $user->setUniCode($unicode);
            $user->setParent($unicode->getOwner()->getUsername());

            $em->persist($unicode);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Bienvenue à toi ! Tu peux désormais te connecter pour acceder aux Needs. Ne tarde pas trop :)');
            return $this->redirectToRoute('login');
        }

        return $this->render(':security:register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
