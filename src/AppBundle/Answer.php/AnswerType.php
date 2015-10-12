<?php

/**
* Statement creation class
* @author Antti Eloranta <anttioeloranta@gmail.com>
*/

namespace AppBundle\Questionnaire;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnswerType extends AbstractType
{
  /**
  * @param FormBuilderInterface $builder
  * @param $array               $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('statement', 'entity', array(
      'class' => 'AppBundle:Statement',
      'property' => 'statement',
      'multiple' => false,
      'expanded' => true))
    ->add('answer', 'choice', array(
        'choices' => array(
            '1' => 'Disagree completely',
            '2' => 'Slightly disagree',
            '3' => 'Slightly agree',
            '4' => 'Agree completely',
            ),
        'label' => 'Opinion',
        'required' => false,
        ));
  }

  /**
  * @param OptionsResolver $resolver
  */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Answer',
  ));
}

/**
* @return string
*/

public function getName()
{
  return 'app_answer';
}
}

?>