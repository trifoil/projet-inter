<?php 
require ('src/model.php');
$parking_enable = getEnablePark();
$parking_disable = getDisablePark();
require('templates/home.php');
require('templates/gestion.php');

?>