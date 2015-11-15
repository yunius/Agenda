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
 * Description of CollectiveType
 *
 * @author inpiron
 */
class CollectiveType extends AbstractType {
    
    protected $activites;
    protected $objectifs;
    protected $adherents;
    protected $cotations;
    protected $secteur;
    protected $materiels;
    
    public function __construct($activites, $objectifs, $adherents, $cotations, $materiels ,$secteur) {
        $this->activites = $activites;
        $this->objectifs = $objectifs;
        $this->adherents = $adherents;
        $this->cotations = $cotations;
        $this->secteur = $secteur;
        $this->materiels = $materiels;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder
                ->add('typeActivite', 'choice', array(
                    'choices' => $this->activites,
                    'placeholder' => 'Choisissez ou creez une activité',
                    'expanded'=>false, 
                    'multiple'=>false
                ))
                ->add('collTitre', 'text', array (
                    'attr' => array('placeholder' => 'Entrez un titre'),
                    'label' => 'Titre : '
                ))
                ->add('collDateDebut', 'date', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'Choisir une date de debut' ),
                    'format' => 'dd-MM-yyyy',
                    'input' => 'timestamp',
                    
                ))
                ->add('collDateFin', 'date', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'Choisir une date de fin' ),
                    'format' => 'dd-MM-yyyy',
                    'input' => 'timestamp',
                    'required' => false
                    
                ))
                
                ->add('objectif', 'choice', array(
                    'choices' => $this->objectifs,
                    'placeholder' => 'Choisissez ou creez un objectif',
                    'expanded'=>false, 
                    'multiple'=>false,
                    'label' => 'Objectif :'
                ))
//                ->add('secteur', 'choice',array(
//                    'choices' => $this->secteur,
//                    'placeholder' => 'Choisissez ou creez un secteur',
//                    'expanded'=>false, 
//                    'multiple'=>false,
//                    'label' => 'secteur :'
//                ))
                
                ->add('adherent', 'choice', array(
                    'choices' => $this->adherents,
                    'label' => 'désigner un responsable :',
                    'placeholder' => 'modifier l\'encadrant',
                    'expanded'=>false, 
                    'multiple'=>false
                ))
                
                ->add('cotation', 'choice', array(
                    'choices' => $this->cotations,
                    'placeholder' => '-cotation à ajouter-',
                    'label' => 'difficulté :',
                    'required' => false,
                    'expanded'=>false, 
                    'multiple'=>false
                ))
                
                ->add('collDenivele', 'text')
                ->add('MaterielCollective', 'choice', array(
                    'choices' => $this->materiels,
                    'placeholder' => '-materiel à ajouter-',
                    'label' => 'difficulté :',
                    'required' => false,
                    'expanded'=>false, 
                    'multiple'=>false
                ));
//                ->setAction($this->router->generate('ModificationCollective'))
//                ->setMethod("POST");
        
                
                
                
    }
    
    
    public function getName() {
        return 'collective';
    }


}
