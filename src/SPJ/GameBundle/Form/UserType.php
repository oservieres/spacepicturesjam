<?php

namespace SPJ\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('attr'=> array('placeholder' => 'Nom d\'utilisateur')))
            ->add('email', 'text', array('attr'=> array('placeholder' => 'Adresse Email')))
            ->add('password', 'password', array('attr'=> array('placeholder' => 'Mot de passe')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SPJ\GameBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'spj_gamebundle_user';
    }
}
