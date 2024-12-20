<?php 
include ('../src/var.php')
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Car Park</title>
    <link rel="stylesheet" href="../../styles_gestion.css">
</head>
<body>
    <div class="container">
        
        <div class="sidebar">
            <h1>Smartcity</h1>
            <h2>Transport</h2>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Manages transportation</h1>
                <p>Two clicks and you're done!</p>
            </div>
                <div class="parking_manage">
                    <div class="modification">
                        <form class="carpark-form" method="POST" action="add_car.php">
                            <select name="City">            
                            </select>
                            <label for="street">Street</label>
                            <input type="text" name="Street">
                    
                            <label for="places">Number of places</label>
                            <input type="number" id="places" min='0' name="places" placeholder="Enter a number">

                            <div>
                                <input type="radio" id="enable" name="enable" value="1" checked />
                                <label for="enable">Enable</label>
                            </div>
                            <div>
                                <input type="radio" id="disable" name="enable" value="0"/>
                                <label for="disable">Disable</label>
                            </div>
                        
                            <button type="submit" name="connexion" class="confirm-btn">Confirm</button>
                        </form>
                    </div>
                    <div class="stat">
                        <h2>Here is all data of parking </h2>
                        <p>Here you will find all information about transportation </p>
                        <ul>
                            <li>Total of parking : <?php echo $nbr_place;?></li> 
                            <li>Total of place : <?php echo $nbr_place_prise;?> </li>
                            <li>Enable parking : <?php echo $nbr_parking_enable;?></li>
                            <li>Disable parking : <?php echo $nbr_parking_disable;?></li>
                        </ul>
                    </div>
                </div>
            <div class="disconnect">
           <a href="../Loggin/login.html"> <p>USER X <span>🔌 Disconnect</span></p></a>
        </div>

        <div class="home-btn">
            <a href="../index.php">🏠
</body>