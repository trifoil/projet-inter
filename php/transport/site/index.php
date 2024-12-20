<?php 
require ('src/model.php');
$parking_enable = getParking(1);
$parking_disable = getParking(0);
require('templates/home.php');

?>