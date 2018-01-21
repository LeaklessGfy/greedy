<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CodePostalValidator extends ConstraintValidator {
    public function validate($value, Constraint $constraint) {
        if((strlen($value) != 2) && (strlen($value) != 5)) {
            $this->context->addViolation($constraint->message, array('%code%' => $value));
        }
    }
}