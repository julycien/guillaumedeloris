<?php

ini_set('display_errors', 0);

class Connexion {

    public function seConnecter($psCheminParametresConnexion) {

        $tProprietes = parse_ini_file($psCheminParametresConnexion);

        $lsProtocole = $tProprietes["protocole"];
        $lsServeur = $tProprietes["serveur"];
        $lsPort = $tProprietes["port"];
        $lsUT = $tProprietes["ut"];
        $lsMDP = $tProprietes["mdp"];
        $lsBD = $tProprietes["bd"];
        /*
         * Connexion
         */
        $pdo = null;
        try {
            $pdo = new PDO("$lsProtocole:host=$lsServeur;port=$lsPort;dbname=$lsBD;", $lsUT, $lsMDP);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
            $pdo->exec("SET NAMES 'UTF8'");
        } catch (PDOException $ex) {
            $time = date("D, d M Y H:i:s");
            $errorMessage = "\rConnexion.php dao : " . $time. " : " . $ex->getMessage();
            $logFile = "../log//Errors.log";
            error_log($errorMessage, 3, $logFile);
        }
        return $pdo;
    }

    public function seDeconnecter(PDO &$pcnx) {
        $pcnx = null;
    }

}

?>
    