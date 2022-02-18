<?php

session_start();

$idsession = session_id();

require_once '../entities/SiteConnexions.php';
require_once '../daos/SiteConnexionsDAO.php';
require_once '../daos/Connexion.php';
require_once '../daos/Transaxion.php';

//interrogation des connexions
$cnx = new Connexion();
$pdo = $cnx->seConnecter("../conf/bd.ini");
$dao = new SiteConnexionsDAO($pdo);

function getIp() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
};

$p = $dao->selectOne(session_id());
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
    
    if ($adresseIP == "185.73.235.212") {
        $adresseIP = "moi-meme";
    };

    try {
        $tx = new Transaxion();
        $tx->initialiser($pdo);
        $pdo->exec("SET NAMES 'UTF8'");

        $siteconnexions = new SiteConnexions($idconnexion, $idsession, $datesession, $adresseIP);

        $dao = new SiteConnexionsDAO($pdo);
        $affected = $dao->insert($siteconnexions);

        $tx->valider($pdo);

        //echo "<br>" . $affected;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

include '../boundaries/BienvenueIHM.php';
