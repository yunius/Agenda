<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;

use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Description of Adherent
 *
 * @author inpiron
 */
class Adherent extends Popo implements UserInterface {
    
    private $IDadherent;
    private $numLicence;
    private $statut;
    private $nomAdherent;
    private $prenomAdherent;
    private $userName;
    private $motDePasseAdherent;
    private $salt;
    private $DateNaissAdherent;
    private $genreAdherent;
    private $MailAdherent;
    private $adherentLibelleRue;
    private $adherentNumRue;
    private $adherentNumTel;
    private $Vehicule;
    private $co_voitureur;
    private $CompteActif;
    private $IDcommune;
    private $IDclub;
    private $roleAdherent;
    
    
    public function getIDadherent() {
        return $this->IDadherent;
    }

    public function getNumLicence() {
        return $this->numLicence;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getNomAdherent() {
        return $this->nomAdherent;
    }

    public function getPrenomAdherent() {
        return $this->prenomAdherent;
    }
    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->userName;
    }

    public function getPassword() {
        return $this->motDePasseAdherent;
    }
    /**
     * @inheritDoc
     */
    public function getSalt() {
        return $this->salt;
    }

    public function getDateNaissAdherent() {
        return $this->DateNaissAdherent;
    }

    public function getGenreAdherent() {
        return $this->genreAdherent;
    }

    public function getMailAdherent() {
        return $this->MailAdherent;
    }

    public function getAdherentLibelleRue() {
        return $this->adherentLibelleRue;
    }

    public function getAdherentNumRue() {
        return $this->adherentNumRue;
    }

    public function getAdherentNumTel() {
        return $this->adherentNumTel;
    }

    public function getVehicule() {
        return $this->Vehicule;
    }

    public function getCo_voitureur() {
        return $this->co_voitureur;
    }

    public function getCompteActif() {
        return $this->CompteActif;
    }

    public function getIDcommune() {
        return $this->IDcommune;
    }

    public function getIDclub() {
        return $this->IDclub;
    }
    /**
     * @inheritDoc
     */
    public function getRole() {
        return $this->roleAdherent;
    }

    public function setIDadherent($IDadherent) {
        $this->IDadherent = $IDadherent;
    }

    public function setNumLicence($numLicence) {
        $this->numLicence = $numLicence;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function setNomAdherent($nomAdherent) {
        $this->nomAdherent = $nomAdherent;
    }

    public function setPrenomAdherent($prenomAdherent) {
        $this->prenomAdherent = $prenomAdherent;
    }

    public function setUsername($Username) {
        $this->userName = $Username;
    }

    public function setPassword($motDePasseAdherent) {
        $this->motDePasseAdherent = $motDePasseAdherent;
    }
    public function setSalt($salt) {
        $this->salt = $salt;
    }

    public function setDateNaissAdherent($DateNaissAdherent) {
        $this->DateNaissAdherent = $DateNaissAdherent;
    }

    public function setGenreAdherent($genreAdherent) {
        $this->genreAdherent = $genreAdherent;
    }

    public function setMailAdherent($MailAdherent) {
        $this->MailAdherent = $MailAdherent;
    }

    public function setAdherentLibelleRue($adherentLibelleRue) {
        $this->adherentLibelleRue = $adherentLibelleRue;
    }

    public function setAdherentNumRue($adherentNumRue) {
        $this->adherentNumRue = $adherentNumRue;
    }

    public function setAdherentNumTel($adherentNumTel) {
        $this->adherentNumTel = $adherentNumTel;
    }

    public function setVehicule($Vehicule) {
        $this->Vehicule = $Vehicule;
    }

    public function setCo_voitureur($co_voitureur) {
        $this->co_voitureur = $co_voitureur;
    }

    public function setCompteActif($CompteActif) {
        $this->CompteActif = $CompteActif;
    }

    public function setIDcommune($IDcommune) {
        $this->IDcommune = $IDcommune;
    }

    public function setIDclub($IDclub) {
        $this->IDclub = $IDclub;
    }

    public function setRole($roleAdherent) {
        $this->roleAdherent = $roleAdherent;
    }
    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array($this->getRole());
    }


    
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        
    }


}
