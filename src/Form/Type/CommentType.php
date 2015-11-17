<?php

namespace Agenda\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
/**
 * Description of CommentType
 *
 * @author Gilou
 */
class CommentType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('contenu', 'textarea');
    }
    
    public function getName() {
        
        return 'commentaire';
    }
    
}
