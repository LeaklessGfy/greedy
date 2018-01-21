<?php
namespace AppBundle\Form\Type;

use AppBundle\Validator\Constraints\CodePostal;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;

class FavoritCityType extends AbstractType {
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('codePostal', 'text', array(
                'label' => 'Département ou Code postal',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ne laisse pas ce champ vide.'
                    )),
                    new CodePostal()
                ),
                'mapped' => false
            ))
            ->add('city', 'entity', array(
                'label' => 'Votre ville',
                'class' => 'AppBundle:Cities',
                'choice_label' => 'cityNomReel',
                'empty_value' => 'Veuillez indiquer un département ou code postal',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.cityCodePostal = ?1')
                        ->orderBy('u.cityNomReel', 'ASC')
                        ->setParameter(1, 'none');
                },
                'constraints' => new Assert\NotBlank(array(
                    'message' => 'Ne laisse pas ce champ vide.'
                )),
                'mapped' => false
            ));

        $cities = function(FormInterface $form, $cp) {
            if(strlen($cp) === 2) {
                $option = "cityDepartement";
            } elseif(strlen($cp) === 5) {
                $option = "cityCodePostal";
            }
            $cities = $this->em->getRepository('AppBundle:Cities')->findBy(array($option => $cp));

            if($cities) {
                $citiesName = array();
                for($i = 0; $i < count($cities); $i++) {
                    array_push($citiesName,array($cities[$i]->getCityNomReel(), $cities[$i]->getCityId()));
                }
            }

            $form->add('city', 'entity', array(
                'label' => 'Votre ville',
                'class' => 'AppBundle:Cities',
                'choice_label' => 'cityNomReel',
                'empty_value' => 'Veuillez indiquer un département ou code postal',
                'query_builder' => function(EntityRepository $er) use ($cp, $option) {
                    return $er->createQueryBuilder('u')
                        ->where('u.'. $option . ' = ?1')
                        ->orderBy('u.cityNomReel', 'ASC')
                        ->setParameter(1,$cp);
                },
                'constraints' => new Assert\NotBlank(array(
                    'message' => 'Ne laisse pas ce champ vide.'
                )),
                'mapped' => false
            ));
        };

        $builder->get('codePostal')->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) use ($cities) {
            $form = $event->getForm()->getParent();
            $cp = $event->getForm()->getData();
            if((strlen($cp) === 2) or (strlen($cp) === 5)) {
                $cities($form, $cp);
            }
        });

    }

    public function getName() {
        return 'favoritCityForm';
    }
}