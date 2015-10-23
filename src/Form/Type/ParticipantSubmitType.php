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
 * Description of ParticipantSubmitType
 *
 * @author inpiron
 */
class ParticipantSubmitType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('IDcollective', 'hidden');
        $builder->add('adherent', 'hidden');
    }
    
    public function getName() {
        return 'participant';
    }

//put your code here
}
