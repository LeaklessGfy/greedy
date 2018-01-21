<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityRepository;

class CityType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('country', 'text', array(
                'label' => 'Pays',
                'constraints' => array(
                    new Assert\NotBlank
                )
            ))
            ->add('department', 'number', array(
                'label' => 'Département',
                'constraints' => array(
                    new Assert\NotBlank,
                    new Assert\Type(array(
                        'type'    => 'numeric'
                    )),
                    new Assert\length((array('min' => 2, 'max' => 2)))
                )
            ))
            ->add('name', 'text', array(
                'label' => 'Ville',
                'constraints' => new Assert\NotBlank()
            ));
    }

    public function getName() {
        return 'cityForm';
    }
}