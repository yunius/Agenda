<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Form\Type;

use Agenda\Domain\Adherent;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Description of ParticipantSubmitType
 *
 * @author inpiron
 */
class ParticipantSubmitType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('IDcollective', 'hidden');
//        $builder->add('adherent', 'hidden', array(
//            'data_class' => 'Agenda\Domain\Adherent'
//        ));
    }
    
    public function getName() {
        return 'participant';
    }

//    public function setDefaultOptions(OptionsResolverInterface $resolver) {
//        $resolver->setDefaults( array (
//        'data_class' => 'Agenda\Domain\Participant',
//        ));
//    }
}
