<?php
 // Connexion à la base de données
include 'loginbd.php';
include '../src/model.php'; // Inclusion du fichier contenant la fonction

if (isset($_POST['connexion'])) {
    // Données sécurisées
    $city = $_POST['City'] . ' ' . $_POST['Street'];
    $places = (int)$_POST['places'];
    $enable = (int)$_POST['enable'];

    // Appel de la fonction addParking
    if (addParking($city, $places, $enable)) {
        header('Location: ../index.php');
        exit();
    } else {
        echo "Erreur lors de l'ajout du parking.";
    }
}
if (isset($_POST['update_park'])) {
    // Données sécurisées
    $id = $_POST['idparking'];
    $a_places = (int)$_POST['a_places'];
    $t_places = (int)$_POST['t_places'];
    $enable = (int)$_POST['enable'];

    if (updateParking($id, $a_places,$t_places, $enable)) {
        header('Location: ../index.php');
        exit();
    } else {
        echo "Erreur lors de la màj du parking.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Car Park</title>
    <link rel="stylesheet" href="../style/styles_add_car.css">
</head>
<body>
    <div class="container">
        
        <div class="sidebar">
            <h1>Smartcity</h1>
            <h2>Transport</h2>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Admin page !</h1>
                <p>Two clicks and you're done!</p>
            </div>
            <div class="manage">
                    <div class="modification">
                        <form class="carpark-form" method="POST" action="gestion.php">
                            <select name="City">
                            <?php
                                echo getCityOptions(); //probleme de porter de variable appel direct de la fonction 
                            ?>             
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
                            <br><li>Total of parking : <?php echo getNbrPlaceTotal();;?></li><br>
                            <li>Total of place : <?php echo getNbrPlaceLibre();?> </li><br>
                            <li>Enable parking : <?php echo getNbrParking(1);?></li><br>
                            <li>Disable parking : <?php echo getNbrParking(0)?></li><br>
                        </ul>
                    </div>
            </div>
        <div class="manage">
                    <div class="modification">
                        <form class="carpark-form" method="POST" action="gestion.php">
                            <legend>Update your parking</legend>
                            <p>Choose a parking</p>
                            <select name="idparking">
                            <?php
                                echo getIdParking(); //probleme de porter de variable appel direct de la fonction 
                            ?>             
                            </select>
                            <label for="street">Available place </label>
                            <input type="number" id="a_places" min='0' name="a_places" placeholder="Enter a number">
                    
                            <label for="places">Number Total of places</label>
                            <input type="number" id="t_places" min='0' name="t_places" placeholder="Enter a number">

                            <div>
                                <input type="radio" id="e" name="enable" value="1" checked />
                                <label for="e">Enable</label>
                            </div>
                            <div>
                                <input type="radio" id="d" name="enable" value="0"/>
                                <label for="d">Disable</label>
                            </div>
                            <button type="submit" name="update_park" class="confirm-btn">Confirm</button>
                        </form>
                    </div>
        </div>

        <div class="disconnect">
           <a href="../Loggin/login.html"> <p>USER X <span>🔌 Disconnect</span></p></a>
        </div>
</body>
<footer>
        <div class="home-btn">
            <a href="../index.php">🏠
        </div>
</footer>
</html>