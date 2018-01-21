<?php
namespace AppBundle\Form\Type;

use AppBundle\Validator\Constraints\UniCode;
use AppBundle\Validator\Constraints\UniUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('uniCode', 'text', array(
                'label' => 'CODE UNIQUE',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => "Ne laisse pas ce champ vide."
                    )),
                    new UniCode()
                )
            ))
            ->add('username', 'text', array(
                'label' => 'Pseudonyme',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => "Ne laisse pas ce champ vide."
                    )),
                    new Assert\Length(array('min' => 3)),
                    new UniUser()
                )
            ))
            ->add('password', 'password', array(
                'label' => 'Mot de passe',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => "Ne laisse pas ce champ vide."
                    )),
                    new Assert\Length(array('min' => 5))
                )
            ));
    }

    public function getName() {
        return 'registerForm';
    }
}