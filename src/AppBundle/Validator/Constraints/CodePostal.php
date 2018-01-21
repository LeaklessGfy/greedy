<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CodePostal extends Constraint{
    public $message = "Le code : \"%code%\" n'est pas un département ou un code postal valide";

    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }
}