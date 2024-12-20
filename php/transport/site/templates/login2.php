<!-- FONCTIONNE CONNEXION AVEC LA DB -->

<?php
try {
	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
} catch(Exception $e) {
	die('Erreur : '.$e->getMessage());
}
session_start();
//si le formulaire a été soumis...
if ( isset($_POST['connexion']) ) {
	//on réceptionne, on trime les chaînes et on hache le mot de passe
	$login = trim($_POST['login']) ;
	$password = trim($_POST['password'])  ;
	
	$stmt = $database->prepare("SELECT * FROM auth WHERE username = :login");
	$stmt->bindParam(':login', $login, PDO::PARAM_STR); // Assigner la valeur du login au placeholder

    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
	//si le login et le mot de passe (bill) sont bons... 
	if ($user && $user['password'] == $password) {
        // Utilisateur trouvé, session active
        $_SESSION['nom'] = $user['username'];
        $_SESSION['droit'] = $user['droit'];  // Enregistrer le droit dans la session
        
        // Redirection selon la valeur de droit
        if ($user['droit'] == 1) {
            header('Location: gestion.php');  // Accès à gestion.php
        } else {
            header('Location: ../index.php');  // Accès à index.php
        }
        exit();
    } else {
        // Si les identifiants sont incorrects
        echo "Nom d'utilisateur ou mot de passe incorrect." ;

        sleep(1); // Pour éviter les attaques par force brute

    }


}
else if ( isset($_POST['deconnexion']) ) {
	session_destroy() ;		//on détruit la session
	header('Location:login2.php');
}
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Formulaire de connexion</title>
	<link rel="stylesheet" href="../../styles_login.css">

</head>
<body>
<div class="container">
        <div class="sidebar">
            <h1>Smartcity</h1>
            <h2>Transport</h2>
        </div>
	<?php
	if ( empty($_SESSION) ) {
		?>
		<div class="parking_manage">
                    <div class="modification">
                        <form class="carpark-form" method="POST" action="login2.php">
              			<div>
                        	<label for="username">Your username</label>
                        	<br>
          	              	<input type="text" name="login" id="">
        				</div>
                        <div>
							<label for="password">Your password</label>
							<br>
							<input type="password" name="password" id="">
                        </div>
                        
                            <button type="submit" name="connexion" class="confirm-btn">Confirm</button> 
                        </form>
                    </div>
		<?php
	}
	else {
		?>
		<h1>Déconnexion</h1>
		<?php
		if ($_SESSION['admin']) echo '<p> Bonjour ', $_SESSION['titre'], '</p>';?>
		
		<form method="post" action="login2.php">
			<p><input type="submit" name="deconnexion" value="Déconnexion">
		</form>
		<?php
	}
	?>
</body>
</html>