<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Formulaire de connexion</title>
  <link rel="stylesheet" href="style/styles_login.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h1>Smartcity</h1>
            <h2>Transport</h2>
        </div>
        <form class="carpark-form" method="POST" action="file_php/home.php">
            <div>
                <label for="username">Your username</label><br>
                <input type="text" name="username" id="">
            </div>
            <div>
                <label for="password">Your password</label><br>
                <input type="password" name="password" id="">
            </div>
            <button type="submit" name="Connexion" class="confirm-btn">Confirm</button>
        </form>
    </div>
</body>
<?php
session_start(); // Démarrage de la session
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Connexion à ADDS
    $ldap = connect_to_ldap($username, $password);

    if (!$ldap) {
        // Erreur de connexion
        echo "Erreur de connexion à ADDS.";
    } else {
        // Connexion réussie
        // Enregistre un journal
        file_put_contents("logs/connecte.log", "L'utilisateur " . $username . " s'est connecté à : " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);
        // Démarrer une session pour l'utilisateur
        $_SESSION['username'] = $username;

        // Récupérer le DN de l'utilisateur
        $userDN = get_user_dn($ldap, $username);

        // Vérifier si l'utilisateur fait partie du groupe GG_AdminTransport
        if ($userDN && check_user_group($ldap, $userDN, 'GG_AdminTransport')) {
            // Redirige vers la page admin
            header("Location: file_php/home.php");
        } else {
            // Redirige vers la page user FONCTIONNE PAS 
            header("Location: file_php/gestion.php");
        }
        exit();
    }
}
?>
</html>