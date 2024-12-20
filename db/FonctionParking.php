<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transport_smartcity"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Sélectionner une place de parking aléatoire
$sql = "SELECT IdParking, TotalPlace FROM parking ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Récupérer les données parking, total des places
    $row = $result->fetch_assoc();
    $idParking = $row['IdParking'];
    $totalPlace = $row['TotalPlace'];

    // Générer un nombre aléatoire de places disponibles entre 0 et TotalPlace
    $availablePlaces = rand(0, $totalPlace);

    // Mettre à jour le nombre de places disponibles dans la base de données
    $updateSql = "UPDATE parking SET AvailablePlaces = $availablePlaces WHERE IdParking = $idParking";
    if ($conn->query($updateSql) === TRUE) {
        echo "Enregistrement mis à jour avec succès";
    } else {
        echo "Erreur lors de la mise à jour de l'enregistrement: " . $conn->error;
    }

    echo json_encode(array('IdParking' => $idParking, 'AvailablePlaces' => $availablePlaces));
} else {
    echo "Aucune place de parking trouvée";
}

$conn->close();
?>