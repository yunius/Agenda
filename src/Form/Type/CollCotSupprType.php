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
 * Description of CollCotSupprType
 *
 * @author inpiron
 */
class CollCotSupprType extends AbstractType {
    
    private $router;
    
    public function __construct($router) {
        $this->router = $router;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('IDcollective', 'text')
                ->add('IDcotation', 'text')
                ->setAction($this->router->generate('CollectiveCotationAsuppr'))
                ->setMethod("POST");
    }
    
    
    public function getName() {
        return 'collectiveCotation';
    }

}
