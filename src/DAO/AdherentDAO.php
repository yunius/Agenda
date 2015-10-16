<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;

use Agenda\Domain\Adherent;
/**
 * Description of AdherentDAO
 *
 * @author inpiron
 */
class AdherentDAO extends DAO{
    
    public function find($IDadherent) {
        $sql = "SELECT * FROM adherents WHERE IDadherent=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDadherent));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new Exception("pas de d'adherent n°" . $IDadherent);
        }
    }
    
    
    public function findAll() {
        $sql = "SELECT * FROM adherents ORDER BY IDadherent";
        $result = $this->getDB()->fetchAll($sql);
        
        $adherents = array();
        foreach ($result as $row) {
            $IDadherent = $row['IDadherent'];
            $adherents[$IDadherent] = $this->buildDomainObject($row);            
        }
        return $adherents;
        
    }
    
    protected function buildDomainObject($row) {
        $adherent = new Adherent();
        $adherent->setIDadherent($row['IDadherent']);
        $adherent->setNumLicence($row['numLicence']);
        $adherent->setStatut($row['statut']);
        $adherent->setNomAdherent($row['nomAdherent']);
	$adherent->setPrenomAdherent($row['prenomAdherent']);
	$adherent->setPseudoAdherent($row['pseudoAdherent']);
	$adherent->setMotDePasseAdherent($row['motDePasseAdherent']);
	$adherent->setDateNaissAdherent($row['DateNaissAdherent']);
	$adherent->setGenreAdherent($row['genreAdherent']);
	$adherent->setMailAdherent($row['MailAdherent']);
	$adherent->setAdherentLibelleRue($row['adherentLibelleRue']);
	$adherent->setAdherentNumRue($row['adherentNumRue']);
	$adherent->setAdherentNumTel($row['adherentNumTel']);
	$adherent->setVehicule($row['Vehicule']);
	$adherent->setCo_voitureur($row['co_voitureur']);
	$adherent->setCompteActif($row['CompteActif']);
	$adherent->setIDcommune($row['IDcommune']);
	$adherent->setIDclub($row['IDclub']);
	$adherent->setIDrole($row['IDrole']);
        
        return $adherent;
    }

}
