<?php
session_start();
//http://localhost/guillaumedeloris/daos/SiteConnexionsDAOSelectAllTest.php

require_once '../entities/SiteConnexions.php';
require_once '../daos/SiteConnexionsDAO.php';
require_once '../daos/Connexion.php';
require_once '../daos/Transaxion.php';

$cnx = new Connexion();
$pdo = $cnx->seConnecter("../conf/bd.ini");
$dao = new SiteConnexionsDAO($pdo);

echo "<hr>select all<hr>";
    $p = $dao->selectAll();

    foreach ($p as $object) {
    echo $p->getIdConnexion() . "<br>";
    echo $p->getIdSession() . "<br>";
    echo $p->getDateSession() . "<br>";
    echo $p->getIdentifiantAdmin() . "<br>";
    }

?>