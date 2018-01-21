<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class PasswordType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('formerPassword', 'password', array(
                'label' => 'Mot de passe actuel',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ne laisse pas ce champ vide.'
                    )),
                    new UserPassword(array(
                        'message' => 'Le mot de passe entré n\'est pas ton mot de passe.'
                    ))
                ),
                'mapped' => false
            ))
            ->add('password', 'repeated', array(
                'label' => 'Nouveau mot de passe',
                'type' => 'password',
                'first_options' => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmation'),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ne laisse pas ce champ vide.'
                    )),
                    new Assert\Length(array('min' => 5))
                )
            ));
    }

    public function getName() {
        return 'passwordForm';
    }
}