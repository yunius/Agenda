<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Agenda\Domain;

use DateTime;
/**
 * Description of Popo
 *
 * @author Gilou
 */
abstract class Popo {
    
    /*public function __construct(array $data) {
        $this->Hydrate($data);
    }
    
    public function Hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }*/
    
    protected function date2FullFr($date) {
	date_default_timezone_set('Europe/Paris');
	setlocale(LC_TIME, 'fra_fra');
	$time = new DateTime($date);
	$output = utf8_encode(strftime("%A %d %B %Y",strtotime($time->format('j F'))));
	return $output;
    }
}
