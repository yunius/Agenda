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
 * Description of filtreType
 *
 * @author inpiron
 */
class filtreType extends AbstractType {
    
    private $typeActivites;
    private $encadrants;
    
    public function __construct($typeActivites, $encadrants ) {
        $this->typeActivites = $typeActivites;
        $this->encadrants = $encadrants;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('typeActivite', 'choice', array(
                    'choices' => $this->typeActivites,
                    'placeholder' => 'Activités',
                    'expanded'=>false, 
                    'multiple'=>false
                ))
//                ->add('adherent', 'choice', array(
//                    'choices' => $this->adherents,
//                    'label' => 'désigner un responsable :',
//                    'placeholder' => 'modifier l\'encadrant',
//                    'expanded'=>false, 
//                    'multiple'=>false
                ->add('debutPeriode', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'input' => 'timestamp'
                ))
                ->add('finPeriode', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'input' => 'timestamp'
                ));
    }
    
    
    public function getName() {
        return 'filtre';
    }

//put your code here
}
