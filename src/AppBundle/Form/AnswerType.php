<?php
/**
 * Answer creation class
 * @author Turo Mikkonen <turo.mikkonen@gmail.com> 27.10.2015
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
  /**
   * In this formBuilder we use AnswerType form builder
   * to get questionnaireFields in answerform
   *
   * @param FormBuilderInterface  $builder
   * @param $array                $options
   */

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('questionnaire', 'entity', array(
      'class' => 'AppBundle:Questionnaire',
      'property' => 'questionnaire',
      'multiple' => true,
      'expanded' => true))
    ->add('statements', 'entity', array(
      'class' => 'AppBundle:Statement',
      'property' => 'statement',
      'multiple' => true,
      'expanded' => true))
      ->add('value', 'integer', array(
        'label' => 'label.value'));
  }

/**
 * @param  OptionsResolver $resolver
 */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Answer'));
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
