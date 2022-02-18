<?php
/*
 * ConnexionTest.php
 */
require_once '../daos/Connexion.php';

$cnx = new Connexion();

$pdo = $cnx->seConnecter("../conf/bd.ini");

echo "<br><pre>";
var_dump($pdo);
echo "</pre><br>";

//$cnx->seDeconnecter($pdo);
?>
