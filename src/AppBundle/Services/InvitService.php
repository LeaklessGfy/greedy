<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\UniCode;

class InvitService
{
    public function __construct(Session $session, EntityManager $em, Container $container)
    {
        $this->session = $session;
        $this->em = $em;
        $this->container = $container;
    }

    public function random($car)
    {
        $string = "";
        $chaine = "abcdefghijklmnpqrstuvwxy0123456789";
        srand((double)microtime()*1000000);
        for($i=0; $i<$car; $i++) {
            $string .= $chaine[rand()%strlen($chaine)];
        }
        return $string;
    }

    public function handleInvitation($request, $codeLeft, $user, $codeToGenerate)
    {
        $uniCode = new UniCode($user);

        if ($request->getMethod() == 'POST' && $request->request->get('generateOneCode') === $codeToGenerate) {
            $codeToGenerate = $this->random(rand(7, 15));
            $this->container->get('session')->set("codeToGenerate", $codeToGenerate);

            if (count($codeLeft) > 10) {
                $this->addFlash('danger', 'Tu as épuisé le nombre de code que tu peux générer');
                return null;
            }

            $rawCode = $this->random(rand(7, 12));
            $generatedCode = $this->container->get('nzo_url_encryptor')->encrypt($rawCode);
            $uniCode->setCode($generatedCode);

            $this->em->persist($uniCode);
            $this->em->flush();

            $hideSecurity = false;

            return array("generatedCode" => $generatedCode, "codeToGenerate" => $codeToGenerate, "hideSecurity" => $hideSecurity);
        }
    }
}
