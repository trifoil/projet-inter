<?php 
date_default_timezone_set('Europe/Brussels');
$hote='root';
$nomBD='transport_smartcity';
$user='root';
$mdp='';
try {
 $bd=new PDO('mysql:host='.$hote.';dbname='.$nomBD, $user, $mdp);
 $bd->exec("SET NAMES 'utf8'");
}
catch (Exception $e) {
 echo "Erreur de connexion à la BD : $e";
}

?>

