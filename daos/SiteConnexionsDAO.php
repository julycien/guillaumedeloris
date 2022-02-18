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
                //echo "trouvé";
                $siteconnexions = new SiteConnexions($record["idconnexion"], $record["idsession"], $record["datesession"], $record["adresseip"]);
            } else {
                $siteconnexions = new SiteConnexions(0, 0, 0, 0);
                //echo "non trouvé<br>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
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

        } catch (Exception $exc) {
            $affected = -1;
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
            echo "KOOOO";
        }
        return $tSiteConnexions;
    }

    public static function update(\PDO $pdo, $object): int {
        
    }

  
    }

   

