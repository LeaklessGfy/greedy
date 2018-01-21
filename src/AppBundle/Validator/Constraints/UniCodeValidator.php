<?php

namespace AppBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniCodeValidator extends ConstraintValidator {
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        $unicodeValid = $this->em->getRepository('AppBundle:UniCode')->findOneBy(array('code' => $value));

        if (!$unicodeValid || $unicodeValid->getAvailable() != 1) {
            $this->context->addViolation($constraint->message);
        }
    }
}