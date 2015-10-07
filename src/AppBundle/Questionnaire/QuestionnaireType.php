<?php
/**
* Questionnaire creation class
* @author Turo Mikkonen 6.10.2015
*/

namespace AppBundle\Questionnaire;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
  /**
   * In this formBuilder we use StatementType form builder
   * to get statementFields in QuestionnaireForm
   * 
   * @param FormBuilderInterface $builder
   * @param $array               $options
   */

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('Questionnaire', null, array('label' => 'label.questionnaire'))
    ->add('statementFields', 'collection', array('type' => new StatementType())
    ->add('sprintRound', 'integer', array(
        'label' => 'label.sprintRound',)
    ->add('extraRound', null, array('label' => 'label.extraRound'));
  }

  /**
   * @param OptionsResolver $resolver
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Questionnaire',
  ));
  }

  /**
   * @return string
   */
  public function getName()
  {
    return 'app_questionnaire';
  }
}


?>
