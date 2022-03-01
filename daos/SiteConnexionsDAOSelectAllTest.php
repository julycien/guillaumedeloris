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

try {
    $p = $dao->selectAll();

    foreach ($p as $object) {
    echo $object->getIdConnexion() . "<br>";
    echo $object->getIdSession() . "<br>";
    echo $object->getDateSession() . "<br>";
    echo $object->getAdresseIp() . "<br>";
   } 
} catch (Exception $ex) {
    $time = date("D, d M Y H:i:s");
    $errorMessage = "\rTdbCTRL.php : " . $time . " : " . $ex->getMessage();
    $logFile = "../log//Errors.log";
    error_log($errorMessage, 3, $logFile);
}

echo "<hr>select all<hr>";
?>