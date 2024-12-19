<?php
require ('src/model.php');
try  {
    $parking_enable = getParking(1);
    $parking_disable = getParking(0);
    $busy_place = getOccupedPlaces();
    $traffic_light_enable = getTrafficLight(1);
    $traffic_light_disable = getTrafficLight(0);
    $sum_enable= getNbrTrafficLight(1);
    $sum_disable = getNbrTrafficLight(0);
    require('file_php/home.php');
}
catch (Exception $e) {
    echo '<html><body>Erreur ! ' . $e->getMessage() . '</body></html>';
}
?>