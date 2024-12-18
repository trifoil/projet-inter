<?php
if (isset($_POST['connexion']) ){
    $new_City = $_POST['City'] . ' ' . $_POST['Street'];   
    $new_Places = (int )$_POST['places'];
    $new_StateUp = (int)$_POST['StateUp'];
    $modifBD = $bd->prepare('INSERT parking
    SET Location=:city, TotalPlace=:places , AvailablePlaces=:places, StateUp=:StateUp');
    $modifBD->bindValue(':city', $new_City);
    $modifBD->bindValue(':places', $new_Places);
    $modifBD->bindValue(':StaeUp', $new_StateUp);
    if ($modifBD->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo "Erreur";
    }
    $modifBD->closeCursor();
}
?>









<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Car Park</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        
        <div class="sidebar">
            <h1>Smartcity</h1>
            <h2>Transport</h2>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Add a car park!</h1>
                <p>Two clicks and you're done!</p>
            </div>
<!-- Formulaire -->
            <form class="carpark-form" method="POST" action="add_car.php">
                
                   
                <select name="City" id="">
                <?php 
               
               include '../loginbd.php';
                   $reqCat = $bd->prepare('SELECT * FROM city ');
                   $reqCat->execute();
                   while ( $cat=$reqCat->fetch() ) {
                       echo '<option value="',$cat['Name'],'">',$cat['Name'],'</option>';
                   }
                   ?>
                    
                </select>
                
                
                <label for="street">Street</label>
                <input type="text" name="Street">

                <label for="places">Number of places</label>
                <input type="number" id="places" name="places" placeholder="Enter a number">
                
                <div>
                    <input type="radio" id="StateUp" name="enable" value="1" checked />
                    <label for="StateUp">Enable</label>
                </div>
                <div>
                    <input type="radio" id="StateDown" name="enable" value="0"/>
                    <label for="StateDown">Disable</label>
                </div>
                <button type="submit" name="connexion" class="confirm-btn">Confirm</button>
            </form>
        </div>

        <div class="disconnect">
           <a href="../Loggin/login.html"> <p>USER X <span>🔌 Disconnect</span></p></a>
        </div>

        <div class="home-btn">
            <a href="../index.php">🏠
