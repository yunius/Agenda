<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;
/**
 * Description of Participant
 *
 * @author inpiron
 */
class Participant extends Popo {
    
    private $IDetats;
    private $adherent;
    private $IDcollective;
    
    public function getIDetats() {
        return $this->IDetats;
    }

    public function getAdherent() {
        return $this->adherent;
    }

    public function getIDcollective() {
        return $this->IDcollective;
    }

    public function setIDetats($IDetats) {
        $this->IDetats = $IDetats;
    }

    public function setAdherent(Adherent $adherent) {
        $this->IDadherent = $IDadherent;
    }

    public function setIDcollective($IDcollective) {
        $this->IDcollective = $IDcollective;
    }


}
