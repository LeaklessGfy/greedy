<?php

namespace AppBundle\Validator\Constraints;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniUserValidator extends ConstraintValidator {
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        $usernameTaken = $this->em->getRepository('AppBundle:User')->findOneBy(array('username' => $value));

        if ($usernameTaken) {
            $this->context->addViolation($constraint->message);
        }
    }
}