<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Agenda\DAO;

use Agenda\Domain\Commentaire;

/**
 * Description of CommentaireDAO
 *
 * @author Gilou
 */
class CommentaireDAO extends DAO {
    
    private $adherentDAO;
    
    public function setAdherentDAO(AdherentDAO $adherentDAO) {
        $this->adherentDAO = $adherentDAO;
    }
    
    public function countCommentaire($IDcollective) {
        $sql = "SELECT count(*) AS decompte FROM commentaire WHERE IDcollective=?";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        foreach ($result as $row) {
               $nb = $row['decompte'];      
        }
        return $nb;
    }
    
    public function save(Commentaire $comment) {
        $IDcollective = $comment->getIDcollective();
        $decompte = $this->countCommentaire($IDcollective);
        $newComCompteur = $decompte++; 
            $commentData = array(
                'ComCompteur' => $newComCompteur,
                'contenu' => $comment->getContenu(),
                'IDadherent'   => $comment->getAdherent()->getIDadherent(),
                'IDcollective' => $comment->getIDcollective()
            );
            if($comment->getComCompteur()) {
                $this->getDB()->update('commentaire', $commentData, array('ComCompteur' => $comment->getComCompteur()));
            }
            else {
                $this->getDB()->insert('commentaire', $commentData);
            }
        
    }
    
    public function find($comCompteur) {
        $sql = "SELECT * FROM commentaire WHERE comCompteur=?";
        $row = $this->getDB()->fetchAssoc($sql, array($comCompteur));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de commentaire correspondant");
        }
    }
    
    
    public function findAll($IDcollective) {
        $sql = "SELECT * FROM commentaire WHERE IDcollective=? ORDER BY ComCompteur DESC";
        $result = $this->getDB()->fetchAll($sql, array($IDcollective));
        
        $commentaires = array();
        foreach ($result as $row) {
            $ComCompteur = $row['ComCompteur'];
            $commentaires[$ComCompteur] = $this->buildDomainObject($row);            
        }
        return $commentaires;
        
    }
    
    protected function buildDomainObject($row) {
        $commentaire = new Commentaire();
        $commentaire->setComCompteur($row['ComCompteur']);
        $commentaire->setContenu($row['contenu']);
        $commentaire->setComHorodateur($row['comHorodateur']);
        if(array_key_exists('IDadherent', $row)) {
            $IDadherent = $row['IDadherent'];
            $adherent = $this->adherentDAO->find($IDadherent);
            $commentaire->setAdherent($adherent);
        }
        $commentaire->setIDcollective($row['IDcollective']);
        
        return $commentaire;
    }
}
