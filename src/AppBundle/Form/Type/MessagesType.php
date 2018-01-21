<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MessagesType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('content', 'textarea', array(
                'label' => false,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ne laisse pas ce champ vide.'
                    ))
                )
            ));
    }

    public function getName() {
        return 'messagesForm';
    }
}