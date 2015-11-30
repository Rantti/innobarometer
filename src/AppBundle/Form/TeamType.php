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
use AppBundle\Entity\User;
use AppBundle\Entity\Team;


/**
 * @author Antti Eloranta anttioeloranta@gmail.com
 */
class TeamType extends AbstractType
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

        


        
        $builder
        ->add('teamName', 'text', array('label' => 'label.teamName'))
        ->add('country', 'choice', array('choices' => array('FIN' => 'Finland', 'EST' => 'Estonia', 'NOR' => 'Norway', 'RU' => 'Russia', 'SWE' => 'Sweden'), 
            'required' => true,))

        ->add('users', 'entity', array(
            'class' => 'AppBundle:User',
            'choice_label' => 'username',
            'property' => 'user',
            'multiple' => 'true',
            'expanded' => 'true'
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Team',
            ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        // Best Practice: use 'app_' as the prefix of your custom form types names
        // see http://symfony.com/doc/current/best_practices/forms.html#custom-form-field-types
        return 'app_team';
    }
}
