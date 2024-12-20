<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Formulaire de connexion</title>
  <link rel="stylesheet" href="../../styles_login.css">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h1>Smartcity</h1>
      <h2>Transport</h2>
    </div>
    <div class="parking_manage">
      <div class="modification">
        <form class="carpark-form" method="POST" action="login3.php">
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
    </div>
  </div>
<?php
session_start(); // Démarrage de la session

// Fonction pour se connecter à ADDS via LDAP
function connect_to_ldap($username, $password) {
    // Paramètres de connexion à ADDS
    $ldapHost = 'ldap://192.168.100.2'; // URL de ton serveur LDAP
    $ldapPort = 389; // Port LDAP par défaut
    $ldapBaseDn = 'DC=smartcity,DC=lan';

    // Connexion à ADDS
    $ldap = ldap_connect($ldapHost, $ldapPort);
    if (!$ldap) {
        return false;
    }
    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    // Authentification sur ADDS
    $bind = ldap_bind($ldap, $username . "@smartcity.lan", $password);
    if (!$bind) {
        return false;
    }

    // Retourne la connexion à ADDS
    return $ldap;
}

// Fonction pour récupérer le DN de l'utilisateur
function get_user_dn($ldap, $username) {
    $filter = "(sAMAccountName=$username)";
    $result = ldap_search($ldap, "DC=smartcity,DC=lan", $filter, array("dn"));
    $entries = ldap_get_entries($ldap, $result);
    return ($entries["count"] > 0) ? $entries[0]["dn"] : null;
}

// Fonction pour vérifier si l'utilisateur fait partie du groupe
function check_user_group($ldap, $userDN, $group) {
    $filter = "(member=CN=$group,OU=GG,OU=Groups,DC=smartcity,DC=lan)";
    $result = ldap_search($ldap, $userDN, $filter, array("dn"));
    $entries = ldap_get_entries($ldap, $result);
    return ($entries["count"] > 0);
}

// Traitement du formulaire
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
            header("Location: admin.php");
        } else {
            // Redirige vers la page user FONCTIONNE PAS 
            header("Location: home.php");
        }
        exit();
    }
}
?>
