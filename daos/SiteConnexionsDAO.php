<?php

require_once '../entities/SiteConnexions.php';

class SiteConnexionsDAO {

    private $pdo;

    function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function SelectOne($pk): SiteConnexions {
        try {
            $cursor = $this->pdo->prepare('SELECT * FROM connexions WHERE idsession = ? ORDER BY 1 DESC LIMIT 1 ');
            $cursor->bindParam(1, $pk);
            $cursor->execute();
            $record = $cursor->fetch();
            if ($record != null) {

                $siteconnexions = new SiteConnexions($record["idconnexion"], $record["idsession"], $record["datesession"], $record["adresseip"]);
            } else {
                $siteconnexions = new SiteConnexions(0, 0, 0, 0);
            }
        } catch (PDOException $e) {
            $time = date("D, d M Y H:i:s");
            $errorMessage = "\rSiteConnexionsDAO.php : " . $time . " : " . $ex->getMessage();
            $logFile = "../log//Errors.log";
            error_log($errorMessage, 3, $logFile);
        }
        return $siteconnexions;
    }

    public function insert(SiteConnexions $siteconnexions): int {
        // Déclaration d'une variable qui servira pour le retour
        $affected = 0;

        try {
            // Compilation
            $cmd = $this->pdo->prepare("INSERT INTO connexions(idconnexion, idsession, datesession, adresseip) "
                    . "VALUES(?,?,?,?)");

            // Valorisation des paramètres (les ?) avec le résultat de la sollicitation de la méthode GETTER de l'objet SiteConnexions
            $cmd->bindValue(1, $siteconnexions->getIdConnexion());
            $cmd->bindValue(2, $siteconnexions->getIdSession());
            $cmd->bindValue(3, $siteconnexions->getDateSession());
            $cmd->bindValue(4, $siteconnexions->getAdresseIP());

            // On exécute la requete
            $cmd->execute();
            // Nombre de lignes affectées (0 ou 1)
            $affected = $cmd->rowCount();
        } catch (Exception $ex) {
            $affected = -1;
            $time = date("D, d M Y H:i:s");
            $errorMessage = "\rBienvenueCTRL.php : " . $time . " : " . $ex->getMessage();
            $logFile = "../log//Errors.log";
            error_log($errorMessage, 3, $logFile);
        }
        return $affected;
    }

    public function selectAll(): array {
        $tAdmin = array();
        try {
            $cursor = $this->pdo->query("SELECT * FROM connexions");
            $cursor->setFetchMode(PDO::FETCH_ASSOC);
            while ($record = $cursor->fetch()) {
                $siteconnexions = new SiteConnexions($record["idconnexion"], $record["idsession"], $record["datesession"], $record["adresseip"]);
                $tSiteConnexions[] = $siteconnexions;
            }
            //$cursor->close();
        } catch (Exception $ex) {
            $tSiteConnexions[] = new Admin("-1", $ex->getMessage());
            $time = date("D, d M Y H:i:s");
            $errorMessage = "\rBienvenueCTRL.php : " . $time . " : " . $ex->getMessage();
            $logFile = "../log//Errors.log";
            error_log($errorMessage, 3, $logFile);
        }
        return $tSiteConnexions;
    }

    public static function update(\PDO $pdo, $object): int {
        
    }

}
