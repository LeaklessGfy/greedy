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

class NeedsType extends AbstractType {
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $month = date('m')+2;
        $year = date('Y');
        if($month > 12) {
            $ecart = $month - 12;
            $month = $ecart;
            $year += 1;
        }
        $date = date($month . '/d/' . $year);
        $builder
            ->add('title', 'text', array(
                'label' => 'Nom du produit',
            ))
            ->add('description', 'textarea', array(
                'label' => 'Description (optionnelle)'
            ))
            ->add('quantity', 'text', array(
                'label' => 'Quantité'
            ))
            ->add('measure', 'choice', array(
                'choices' => array(
                    'unit' => 'Unité',
                    'kg' => 'Kilogramme',
                    'g' => 'Gramme',
                    'mg' => 'Milligramme',
                    'L' => 'Litre',
                    'cL' => 'Centilitre',
                    'mL' => 'Millilitre'
                ),
                'label' => 'Mesure',
                'empty_value' => 'Choisissez une unité',
            ))
            ->add('endDate', 'collot_datetime',array(
                'label' => 'Date limite',
                'pickerOptions' =>
                    array('format' => 'm/d/yyyy H:i',
                        'weekStart' => 0,
                        'startDate' => date('m/d/Y H:i'), //example
                        'endDate' => date("m/t/Y H:i", strtotime($date)),
                        'autoclose' => true,
                        'startView' => 'month',
                        'minView' => 'hour',
                        'maxView' => 'decade',
                        'todayBtn' => true,
                        'todayHighlight' => true,
                        'keyboardNavigation' => true,
                        'language' => 'fr',
                        'forceParse' => true,
                        'minuteStep' => 30,
                        'pickerReferer ' => 'input', //deprecated
                        'pickerPosition' => 'bottom-right',
                        'viewSelect' => 'hour',
                        'showMeridian' => false,
                        'initialDate' => date('m/d/Y'), //example
                    )
            ))
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
        return 'needsForm';
    }
}