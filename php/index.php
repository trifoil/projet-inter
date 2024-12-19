<?php
require ('src/model.php');
try  {
    $parking_enable = getParking(1);
    $parking_disable = getParking(0);
    require('file_php/home.php');
}
catch (Exception $e) {
    echo '<html><body>Erreur ! ' . $e->getMessage() . '</body></html>';
}
?>