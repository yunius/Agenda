<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\DAO;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Agenda\Domain\Adherent;


/**
 * Description of AdherentDAO
 *
 * @author Gilou
 */
class AdherentDAO extends DAO implements UserProviderInterface{
    
    public function find($IDadherent) {
        $sql = "SELECT * FROM adherents WHERE IDadherent=?";
        $row = $this->getDB()->fetchAssoc($sql, array($IDadherent));
        
        if($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new \Exception("pas de d'adherent n°" . $IDadherent);
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
    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username) {
        $sql = "SELECT * FROM adherents WHERE pseudoAdherent=?";
        $row = $this->getDB()->fetchAssoc($sql, array($username));
        
        if ($row) {
            return $this->buildDomainObject($row);
        }
        else {
            throw new UsernameNotFoundException(sprintf('uilisateur "%s" non trouvé.', $username));
            
        }
    }
    
    public function refreshUser(UserInterface $adherent) {
        $class = get_class($adherent);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($adherent->getUsername());
    }
    
    public function supportsClass($class) {
        return 'Agenda\Domain\Adherent' === $class;
    }
    
    protected function buildDomainObject($row) {
        $adherent = new Adherent();
        $adherent->setIDadherent($row['IDadherent']);
        $adherent->setNumLicence($row['numLicence']);
        $adherent->setStatut($row['statut']);
        $adherent->setNomAdherent($row['nomAdherent']);
	$adherent->setPrenomAdherent($row['prenomAdherent']);
	$adherent->setUsername($row['pseudoAdherent']);
	$adherent->setPassword($row['motDePasseAdherent']);
        $adherent->setSalt($row['adherent_salt']);
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
	$adherent->setRole($row['roleAdherent']);
        
        return $adherent;
    }

}
