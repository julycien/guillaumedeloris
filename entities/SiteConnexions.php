<?php

class SiteConnexions {

    private $idConnexion;
    private $idSession;
    private $dateSession;
    private $adresseIP;

    function __construct($idConnexion = "", $idSession = "", $dateSession = "", $adresseIP = "") {

        $this->idConnexion = $idConnexion;
        $this->idSession = $idSession;
        $this->dateSession = $dateSession;
        $this->adresseIP = $adresseIP;
    }

    function getIdConnexion() {
        return $this->idConnexion;
    }

    function getIdSession() {
        return $this->idSession;
    }

    function getDateSession() {
        return $this->dateSession;
    }

    function getAdresseIP() {
        return $this->adresseIP;
    }

    function setIdConnexion($idConnexion) {
        $this->idConnexion = $idConnexion;
    }

    function setIdSession($idSession) {
        $this->idSession = $idSession;
    }

    function setDateSession($dateSession) {
        $this->dateSession = $dateSession;
    }

    function setAdresseIP($adresseIP) {
        $this->adresseIP = $adresseIP;
    }

    
    }

?>
