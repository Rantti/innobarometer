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
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Team;
use AppBundle\Entity\Project;


/**
 * @author Antti Eloranta anttioeloranta@gmail.com
 */
class ProjectType extends AbstractType
{

    protected $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // For the full reference of options defined by each form field type
        // see http://symfony.com/doc/current/reference/forms/types.html

        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        //
        //     $builder->add('title', null, array('required' => false, ...));





        $builder
        ->add('projectName', 'text', array('label' => 'label.teamName'))
        ->add('startDate', 'date', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            ))
        ->add('endDate', 'date', array(
            'input'  => 'datetime',
            'widget' => 'choice',
            ))
        ->add('collaborators', 'entity', array(
            'class' => 'AppBundle:Team',
            'choice_label' => 'teamName',
            'property' => 'team',
            'multiple' => 'true',
            'expanded' => 'true'
            ))
        ->add('sprintRound', 'integer', array(
        'label' => 'Sprint round #'))
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
