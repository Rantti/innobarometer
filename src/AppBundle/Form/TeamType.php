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
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;
use AppBundle\Entity\Team;

/**
 * @author Antti Eloranta anttioeloranta+job@gmail.com
 */
class TeamType extends AbstractType
{
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
        

        //$userManager = $this->get('fos_user.user_manager');
        //$users = $userManager->findUsers();
        $users = $options['users'];
        $formFactory = $builder->getFormFactory();
        
        $builder
            ->add('teamName', 'text', array('label' => 'label.teamName'))
            ->add('country', 'choice', array('choices' => array('FIN' => 'Finland', 'EST' => 'Estonia', 'NOR' => 'Norway', 'RU' => 'Russia', 'SWE' => 'Sweden'), 
                'required' => true,))
            ->add($formFactory->createNamed("selectedusers", "choices", null, array(
                            "multiple" => true,
                            "expanded" => true,
                            "label" => "Users without teams.",
                            "choices" => $users,
                        )));
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
