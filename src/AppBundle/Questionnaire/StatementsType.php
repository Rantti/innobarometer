<?php

/**
* StatementsType inherit class
* @author Turo Mikkonen 3.10.2015
*/

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class StatementsType extends AbstractType
{
  /**
  * @param FormBuilderInterface $builder
  * @param $array               $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('statement', 'TextType::class'));
    }

    /**
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(array(
        'inherit_data' => true));
      }

      /**
      * @return string
      */

      public function getName()
      {
        return 'app_statements';
      }
    }

    ?>
