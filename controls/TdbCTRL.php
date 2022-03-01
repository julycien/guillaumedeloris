<?php

require_once '../entities/SiteConnexions.php';
require_once '../daos/SiteConnexionsDAO.php';
require_once '../daos/Connexion.php';

try {

    $cnx = new Connexion();
    $pdo = $cnx->seConnecter("../conf/bd.ini");
    $dao = new SiteConnexionsDAO($pdo);

    $p = $dao->selectAll();
    
    $lines = "<table>";

    foreach ($p as $object) {
        $lines .= "<tr><td>" . $object->getIdConnexion() . "</td>";
        $lines .= "<td>" . $object->getIdSession() . "</td>";
        $lines .= "<td>" . $object->getDateSession() . "</td>";
        $lines .= "<td>" . $object->getAdresseIp() . "</td></tr>";
    }
    
    $lines .= "</table>";
            
} catch (Exception $ex) {
    $time = date("D, d M Y H:i:s");
    $errorMessage = "\rTdbCTRL.php : " . $time . " : " . $ex->getMessage();
    $logFile = "../log//Errors.log";
    error_log($errorMessage, 3, $logFile);
}

include '../boundaries/TdbIHM.php';
