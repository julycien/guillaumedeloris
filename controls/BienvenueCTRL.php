<?php

session_start();

$idsession = session_id();

require_once '../entities/SiteConnexions.php';
require_once '../daos/SiteConnexionsDAO.php';
require_once '../daos/Connexion.php';
require_once '../daos/Transaxion.php';

function getIp() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

;



try {

//interrogation des connexions
    $cnx = new Connexion();
    $pdo = $cnx->seConnecter("../conf/bd.ini");
    $dao = new SiteConnexionsDAO($pdo);

    $p = $dao->selectOne(session_id());
} catch (Exception $ex) {
    $time = date("D, d M Y H:i:s");
    $errorMessage = "\rBienvenueCTRL.php : " . $time . " : " . $ex->getMessage();
    $logFile = "../log//Errors.log";
    error_log($errorMessage, 3, $logFile);
}
//L'id de connexion renvoyée par le DAO est 1 si la session est inconnue
if ($p->getIdSession() == 0) {

//si la connexion + l'identifiant n'est pas connue dans la BD -> insert d'une ligne objet SiteConnexion table connexions
    $idconnexion = "";

    $tz = 'Europe/Paris';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    $datesession = $dt->format('Y-m-d H:i:s');
    $adresseIP = getIp();

    if ($adresseIP != "185.73.235.212") {

        $adresseIP = substr(md5($adresseIP), 0, 20);


        try {
            $tx = new Transaxion();
            $tx->initialiser($pdo);
            $pdo->exec("SET NAMES 'UTF8'");

            $siteconnexions = new SiteConnexions($idconnexion, $idsession, $datesession, $adresseIP);

            $dao = new SiteConnexionsDAO($pdo);
            $affected = $dao->insert($siteconnexions);

            $tx->valider($pdo);
        } catch (PDOException $ex) {
            $time = date("D, d M Y H:i:s");
            $errorMessage = "\rBienvenueCTRL.php : " . $time . " : " . $ex->getMessage();
            $logFile = "../log//Errors.log";
            error_log($errorMessage, 3, $logFile);
        }
    };
}

include '../boundaries/BienvenueIHM.php';
