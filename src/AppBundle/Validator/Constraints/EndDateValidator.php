<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EndDateValidator extends ConstraintValidator {
    public function validate($value, Constraint $constraint)
    {
        $today = new \DateTime();
        if ($value) {
            if ($today > $value) {
                $this->context->addViolation($constraint->message);
            }
        }
    }
}