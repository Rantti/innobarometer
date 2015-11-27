<?php

/**
* Statement creation class
* @author Turo Mikkonen 3.10.2015
*/

namespace AppBundle\Questionnaire;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class StatementType extends AbstractType
{
  /**
  * @param FormBuilderInterface $builder
  * @param $array               $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('statement', 'text', array(
      'label' => 'Statement'))
    ->add('category', 'choice', array(
      'choices' => array(
        'Communications' => 'Communications',
        'Well Being' => 'Well Being',
        'Workflow' => 'Workflow',
        'Workplace' => 'Workplace',
        'Miscellaneous' => 'Miscellaneous'),
      'required' => true,
      'label' => 'category'));
  }

  /**
  * @param OptionsResolver $resolver
  */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Statement',
  ));
}

/**
* @return string
*/

public function getName()
{
  return 'app_statement';
}
}

?>
