<?php

function afficheDateSemaine($week) {
    date_default_timezone_set('Europe/Paris');
    setlocale(LC_TIME, 'fra_fra');
    $annee = date('Y');
    $lundi = new DateTime();
    $dimanche = new DateTime();    
    $lundi->setISOdate($annee, $week);
    $dimanche->setISOdate($annee, $week, 7);

    $debut = utf8_encode(strftime("%A %d %B %Y",strtotime($lundi->format('j F Y'))));
    $fin =  utf8_encode(strftime("%A %d %B %Y",strtotime($dimanche->format('j F Y'))));

    $dates['lundiString'] = $debut;
    $dates['dimancheString'] = $fin;
    $dates['lundiIso'] = $lundi;
    $dates['dimancheIso'] = $dimanche;
    return $dates;
}

