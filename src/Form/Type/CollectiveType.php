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
 * @author Gilou
 */
class CollectiveType extends AbstractType {
    
    protected $activites;
    protected $objectifs;
    protected $adherents;
    protected $cotations;
    protected $secteur;
    protected $materiels;
    protected $lieux;
    
    public function __construct($activites, $objectifs, $adherents, $cotations, $materiels , $lieux, $secteur) {
        $this->activites = $activites;
        $this->objectifs = $objectifs;
        $this->adherents = $adherents;
        $this->cotations = $cotations;
        $this->secteur = $secteur;
        $this->materiels = $materiels;
        $this->lieux = $lieux;
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
                    'placeholder' => 'objectif de l\'activité',
                    'expanded'=>false, 
                    'multiple'=>false,
                    'label' => 'objectif :'
                ))
                ->add('secteur', 'choice',array(
                    'choices' => $this->secteur,
                    'placeholder' => 'Choisissez ou creez un secteur',
                    'expanded'=>false, 
                    'multiple'=>false,
                    'label' => 'secteur :'
                ))
                ->add('observation', 'textarea', array(
                    'required' => false,
                    'attr' => array('placeholder' => 'Redigez une observation ou une courte description de votre sortie',
                                    'rows' => 4,
                                    )
                ))
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
                
                ->add('collDenivele', 'text', array(
                    'label' => 'Éstimation dénivelé',
                    'required' => false
                ))
                ->add('MaterielCollective', 'choice', array(
                    'choices' => $this->materiels,
                    'placeholder' => '-materiel à ajouter-',
                    'label' => 'difficulté :',
                    'required' => false,
                    'expanded'=>false, 
                    'multiple'=>false
                ))
                ->add('lieuRDV', 'choice', array(
                    'choices' => $this->lieux,
                    'placeholder' => 'lieu de rendez-vous',
                    'label' => 'Lieu :',
                    'required' => false,
                    'expanded'=>false, 
                    'multiple'=>false
                ))
                ->add('heureRDV', 'time', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'heure' ),
                    'input' => 'timestamp',
                    'label' => 'heure de rendez-vous :',
                    'required' => false
                ))
                ->add('nbMax', 'number', array(
                    'label' => 'Nombre de participant max :',
                    'attr' => array('min' => 1),
                    'required' => false
                ))
                
                //specifique compte rendu tron commun
                
                ->add('collHeureDepartTerrain', 'time', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'heure' ),
                    'input' => 'timestamp',
                    'label' => 'Heure de départ terrain :',
                    'required' => false
                ))
                
                ->add('collHeureRetourTerrain', 'time', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'heure' ),
                    'input' => 'timestamp',
                    'label' => 'Heure de retour terrain :',
                    'required' => false
                ))
                ->add('collConditionMeteo', 'textarea', array(
                    'required' => false,
                    'attr' => array('placeholder' => 'description de la météo',
                                    'rows' => 4,
                                    )
                ))
                ->add('collDureeCourse', 'time', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'Durée' ),
                    'input' => 'timestamp',
                    'label' => 'Durée course sans les pauses :',
                    'required' => false
                ))
                ->add('coll_incident_accident', 'textarea', array(
                    'required' => false,
                    'attr' => array('placeholder' => 'incidents ou accidents ?',
                                    'rows' => 4,
                                    )
                ))
                ->add('collInfoComplementaire', 'textarea', array(
                    'label' => 'Observations particulières (sécurité, balisage, refuge, accès, comportement, etc.)',
                    'required' => false,
                    'attr' => array('placeholder' => 'Observation particuliere',
                                    'rows' => 4,
                                    )
                ))
                //specifique compte rendu en fonction de l'activité
                ->add('collDureeCourseAlpi', 'time', array(
                    'widget' => 'single_text',
                    'attr' => array( 'placeholder' => 'Durée course' ),
                    'input' => 'timestamp',
                    'label' => 'Durée course (hors approche et retour) :',
                    'required' => false
                ))
                ->add('collDureeApproche', 'time', array(
                            'widget' => 'single_text',
                            'attr' => array( 'placeholder' => 'Durée Approche' ),
                            'input' => 'timestamp',
                            'label' => 'Durée approche',
                            'required' => false
                ))
                ->add('collCondition_neige_rocher_glace', 'textarea', array(
                    'label' => 'Observations particulières (sécurité, balisage, refuge, accès, comportement, etc.)',
                    'required' => false,
                    'attr' => array('placeholder' => 'Conditions neige / rocher / glace',
                                    'rows' => 4,
                                    )
                ));
                
                
        
                
        
                
                
                
    }
    
    
    public function getName() {
        return 'collective';
    }


}
