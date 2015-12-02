<?php
/**
 * Answer creation class
 * @author Turo Mikkonen <turo.mikkonen@gmail.com> 27.10.2015
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

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
    // ->add('questionnaire', 'entity', array(
    //   'class' => 'AppBundle:Questionnaire',
    //   'property' => 'id'))
    ->add('statement', 'entity', array(
      'class' => 'AppBundle:Statement',
      'property' => 'statement'))
    ->add('value', 'choice', array(
      'choice_list' => new ChoiceList(
        array(1, 2, 3, 4),
        array('I don\'t agree', 'I disagree a little', 'I agree a little', 'I agree completely' )
    )));
  }

  // function __construct(AppBundle\Entity\Questionnaire $questionnaire, AppBundle\Entity\Statement $statement) {
  //   $this->questionnaire = $questionnaire;
  //   $this->statement = $statement;
  // }

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
