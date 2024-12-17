<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCity Transport</title>
    <link rel="stylesheet" href="styles.css">
</head>
<?php
include 'loginbd.php';
$reqCat = $bd->prepare('SELECT * FROM parking');
$reqCat->execute();
while ( $cat=$reqCat->fetch() ) {
    echo '<p>',$cat['Location'],'</p>';}
    
?>
<body>
    <div class="container">
        <div class="sidebar">
            <h1>Smartcity</h1>
            <h2>Transport</h2>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>State</h1>
                <p>Everything is fine. There are no transportation issues at this time.</p>
            </div>

            <!-- Car and Light Status -->
            <!-- <img src="car.png" alt="" style="width: 20%;"> -->

            <div class="status-section">
                <div class="status-box">
                    <p>🚗 There are currently <span>x</span> cars on the move.</p>
                </div>
                <div class="status-box">
                    <p>🚦 All lights are working properly.</p>
                </div>
            </div>

            <div class="status-section">
                <div class="status-box">
                    <p>🚙 There are currently <span>x</span> cars parked.</p>
                </div>
                <div class="status-box">
                   <a href="/Projet_inter/Add_car/add_car.php"> <button class="add-carpark">Add a car park in SmartCity!</button></a>
                </div>
            </div>

            <!-- Parking Details -->
            <div class="parking-section">
                <h3>The different car parks in SmartCity:</h3>
                <ul>
                    <?php 
                    $reqCat = $bd->prepare('SELECT * FROM parking WHERE StateUp = 1');
                    $reqCat->execute();
                    while ( $cat=$reqCat->fetch() ) {
                        echo '<li>',$cat['Location'],' : ', $cat['AvailablePlaces'], 'places prises sur',$cat['TotalPlace'],  '<button>+</button></li>';}

                    
                    ?>
                    <li>Rue X numéro X: X places prises sur X. <button>+</button></li>
                    <li>Rue X numéro X: X places prises sur X. <button>+</button></li>
                    <li>Rue X numéro X: X places prises sur X. <button>+</button></li>
                </ul>
            </div>
        </div>
        
        <!-- Disconnect -->
        <div class="disconnect">
           <a href="/Loggin/login.html"> <p>USER X <span>🔌 Disconnect</span></p></a>
        </div>
    </div>
</body>
</html>
