<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\Form\Type;
use Agenda\DAO\TypeActiviteDAO;
use Agenda\Domain\TypeActivite;
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
    
    public function __construct($activites, $objectifs, $adherents) {
        $this->activites = $activites;
        $this->objectifs = $objectifs;
        $this->adherents = $adherents;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        setlocale(LC_TIME, 'fr_CA.UTF-8');
        
        $builder
                ->add('typeActivite', 'choice', array(
                    'choices' => $this->activites,
                    'placeholder' => 'Choisissez ou creez une activité',
                    'expanded'=>false, 
                    'multiple'=>false
                ))
                ->add('collTitre', 'text', array (
                    'attr' => array('placeholder' => 'Entrez un titre'),
                    'label' => 'titre'
                ))
                ->add('collDateDebut', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd'
                ))
                
                ->add('objectif', 'choice', array(
                    'choices' => $this->objectifs,
                    'placeholder' => 'Choisissez ou creez un objectif',
                    'expanded'=>false, 
                    'multiple'=>false
                ))
                
                ->add('adherent', 'choice', array(
                    'choices' => $this->adherents,
                    'placeholder' => 'modifier l\'encadrant',
                    'expanded'=>false, 
                    'multiple'=>false
                ));
                
    }
    
    
    public function getName() {
        return 'collective';
    }


}
