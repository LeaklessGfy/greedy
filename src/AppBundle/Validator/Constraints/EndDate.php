<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EndDate extends Constraint{
    public $message = "La date choisi est dépassé";

    public function getTargets() {
        return self::PROPERTY_CONSTRAINT;
    }
}