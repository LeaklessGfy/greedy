<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniUser extends Constraint{
    public $message = "Ce pseudonyme est déjà utilisé.";

    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy() {
        return 'UniUser';
    }
}