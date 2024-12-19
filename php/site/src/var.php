<?php
require ('model.php');

$nbr_parking_disable=getNbrParking(0);
$nbr_parking_enable=getNbrParking(1);
$nbr_place_prise=getNbrPlaceLibre();
$nbr_place=getNbrPlaceTotal();


?>