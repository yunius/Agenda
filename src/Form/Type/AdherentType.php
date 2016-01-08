<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
/**
 * Description of AdherentType
 *
 * @author inpiron
 */
class AdherentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('userName', 'text' )
                ->add('prenomAdherent', 'text')
                ->add('nomAdherent', 'text')
                ->add('MailAdherent', 'email')
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'le mot de passe doit correspondre',
                    'options' => array('required' => true),
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label'=> 'repeter le mot de passe')
                ))
                ->add('role', 'choice', array(
                    'choices' => array('ROLE_REDACTEUR' => 'Encadrant', 'ROLE_USER' => 'Participant')
                ));
    }

    public function getName()
    {
        return 'adherent';
    }

}
