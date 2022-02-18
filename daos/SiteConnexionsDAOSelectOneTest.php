<?php
session_start();
//http://localhost/msrBike/msrBikeAdmin/daos/SiteConnexionsDAOSelectOneTest.php

require_once '../entities/SiteConnexions.php';
require_once '../daos/SiteConnexionsDAO.php';
require_once '../daos/Connexion.php';
require_once '../daos/Transaxion.php';

$cnx = new Connexion();
$pdo = $cnx->seConnecter("../conf/bd.ini");
$dao = new SiteConnexionsDAO($pdo);
echo session_id();
echo "<hr>select one<hr>";
    $p = $dao->selectOne(session_id());
    echo session_id() . "<br>";

    echo $p->getIdConnexion() . "<br>";
    echo $p->getIdSession() . "<br>";
    echo $p->getDateSession() . "<br>";
    echo $p->getAdresseIP() . "<br>";

?>