<?php
require ('src/model.php');
try  {
    require('file_php/login.php');
}
catch (Exception $e) {
    echo '<html><body>Erreur ! ' . $e->getMessage() . '</body></html>';
}
?>