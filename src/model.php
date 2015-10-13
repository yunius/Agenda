<?php
function getRole () {
    $bdd = new PDO('mysql:host=localhost;dbname=agenda;charset=utf8', 'root', '');
    $entrees = $bdd->query('select * from role');
    
    return $entrees;
}

function getCollective() {
    $bdd = new PDO('mysql:host=localhost;dbname=agenda;charset=utf8', 'root', '');
    $entrees = $bdd->query('select * from collectives');
    return $entrees;
}


