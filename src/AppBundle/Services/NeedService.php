<?php

namespace AppBundle\Services;

use AppBundle\Entity\Position;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class NeedService {
    public function __construct(EntityManager $em, Session $session) {
        $this->em = $em;
        $this->session = $session;
    }

    function add($x, $y) { return $x + $y; }
    function subtract($x, $y) { return $x - $y; }

    function checkIfExist($lat, $lng) {
        $already = $this->em->getRepository('AppBundle:Position')->findOneBy(array('latitude' => $lat, 'longitude' => $lng));

        if($already) {
            $hasardLAT = rand(0,269796)/26979600;
            $hasardLNG = rand(0, (269796/cos($lat)))/89979600;
            $operators = array('self::add', 'self::subtract');
            $newLAT = call_user_func_array($operators[array_rand($operators)], array($lat, $hasardLAT));
            $newLNG = call_user_func_array($operators[array_rand($operators)], array($lng, $hasardLNG));
            return self::checkIfExist($newLAT, $newLNG);
        } else {
            return array($lat, $lng);
        }
    }

    public function GetLatLng($address) {
        $prepAddr = str_replace(' ','+',$address->getCityNomSimple());
        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;

        return array($latitude, $longitude);
    }

    public function definePosition($position, $address, $latlng) {
        $position->setCity($address);
        $position->setLatitude($latlng[0]);
        $position->setLongitude($latlng[1]);

        return $position;
    }

    public function handleNeed($formNeeds, $needs) {
        $position = new Position();

        //Google Check
        $address = $formNeeds->get('city')->getData(); // Google HQ
        $latLng = $this->GetLatLng($address);
        //

        $latLng = $this->checkIfExist($latLng[0], $latLng[1]);
        $position = $this->definePosition($position, $address, $latLng);
        $needs->setPosition($position);

        $this->em->persist($position);
        $this->em->persist($needs);
        $this->em->flush();

        $this->session->getFlashBag()->add('success', 'Votre Needs a bien été ajouté');
    }
}