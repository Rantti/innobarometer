<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Team;
use AppBundle\Entity\Project;


/**
 * @author Antti Eloranta anttioeloranta@gmail.com
 */
class ProjectType extends AbstractType
{

    public function __construct()
    {

    }
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('project', 'text', array('label' => 'Project Name'))
        ->add('startDate', 'date', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            ))
        ->add('endDate', 'date', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            ))
        ->add('teams', 'entity', array(
      'class' => 'AppBundle:Team',
      'property' => 'teamName',
      'multiple' => true,
      'expanded' => true))
        ->add('sprintRound', 'integer', array(
        'label' => 'Sprint round number'))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project',
            ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        // Best Practice: use 'app_' as the prefix of your custom form types names
        // see http://symfony.com/doc/current/best_practices/forms.html#custom-form-field-types
        return 'app_project';
    }
}
