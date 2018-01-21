<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints as Assert;

class ReportType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('action', 'choice', array(
                'label' => 'Signalement',
                'choices' => array(
                    'insulte' => 'Insulte',
                    'racisme' => 'Racisme',
                    'fake' => 'Fake',
                    'police' => 'Police'
                ),
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ne laisse pas ce champ vide.'
                    ))
                )
            ))
            ->add('comment', 'textarea', array(
                'label' => 'Commentaire',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ne laisse pas ce champ vide.'
                    ))
                )
            ))
            ->add('reportUser', 'entity', array(
                'label' => false,
                'class' => 'AppBundle:User',
                'choice_label' => 'id',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');;
                },
                'constraints' => new Assert\NotBlank(array(
                    'message' => 'Ne laisse pas ce champ vide.'
                ))
            ));
    }

    public function getName() {
        return 'reportForm';
    }
}