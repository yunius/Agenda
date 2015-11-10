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
        
        $choix = array();
        $choix[0] = 'Un jour precis';
        $choix[1] = 'Une periode';
               
        
        $builder
                ->add('typeActivite', 'choice', array(
                    'choices' => $this->typeActivites,
                    'placeholder' => 'Toute activités',
                    'expanded'=>false, 
                    'multiple'=>false,
                    'required' => false
                ))
//                ->add('choixFiltre', 'choice', array(
//                    'choices' =>$choix,
//                    'expanded'=>true, 
//                    'multiple'=>false,
//                    'empty_value' => false,
//                    'required' => false,
//                    'data' => 0
//                ))
//                ->add('adherent', 'choice', array(
//                    'choices' => $this->adherents,
//                    'label' => 'désigner un responsable :',
//                    'placeholder' => 'modifier l\'encadrant',
//                    'expanded'=>false, 
//                    'multiple'=>false
                ->add('debutPeriode', 'date', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'Choisir une date' ),
                    'format' => 'dd-MM-yyyy',
                    'input' => 'timestamp',
                    'required' => false
                ))
                ->add('finPeriode', 'date', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'Choisir une date' ),
                    'format' => 'dd-MM-yyyy',
                    'input' => 'timestamp',
                    'required' => false,
//                    'attr' => array('class' => 'filtreDateFinHidden'  )
                ));
    }
    
    
    public function getName() {
        return 'filtre';
    }

//put your code here
}
