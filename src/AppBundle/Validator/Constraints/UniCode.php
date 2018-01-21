<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniCode extends Constraint{
    public $message = "Ton code unique n'est pas valide";

    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy() {
        return 'UniCode';
    }
}