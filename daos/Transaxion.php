<?php

class Transaxion {

    public function initialiser(PDO &$pcnx) {
        $lbOK = true;
        try {
            $pcnx->beginTransaction();
        } catch (PDOException $ex) {
            $lbOK = false;
        }
        return $lbOK;
    }

    public function valider(PDO &$pcnx) {
        $lbOK = true;
        try {
            $pcnx->commit();
        } catch (PDOException $ex) {
            $lbOK = false;
        }
        return $lbOK;
    }

    public function annuler(PDO &$pcnx) {
        $lbOK = true;
        try {
            $pcnx->rollback();
        } catch (PDOException $ex) {
            $lbOK = false;
        }
        return $lbOK;
    }
}
