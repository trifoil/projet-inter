<?php
function getBdd() {
    try {
    	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
	} catch(Exception $e) {
    	die('Erreur : '.$e->getMessage());
	}

    return $database;
  }

function getParking($n) {
	// We connect to the database.
	$database = getBdd();
	// Get all available parking 
	$statement = $database->query(
    	"SELECT Location, AvailablePlaces, TotalPlace FROM parking WHERE StateUp =$n"
	);
	$parking_enable = [];
	while (($row = $statement->fetch())) {
    	$parking = [
        	'Location' => $row['Location'],
        	'AvailablePlaces' => $row['AvailablePlaces'],
        	'TotalPlace' => $row['TotalPlace'],
    	];

    	$parking_enable[] = $parking;
	}
	return $parking_enable;
}

function addParking($city, $places, $enable) {
    $database = getBdd();
    $modifBD = $database->prepare('INSERT INTO parking
        SET Location = :city, TotalPlace = :places, AvailablePlaces = :places, StateUp = :StateUp');
    
    $modifBD->bindValue(':city', $city);
    $modifBD->bindValue(':places', $places);
    $modifBD->bindValue(':StateUp', $enable);

    return $modifBD->execute();
}
function getCityOptions() {
    $database = getBdd();
    $reqCat = $database->prepare('SELECT * FROM city');
    $reqCat->execute();
    $options = '';

    while ($cat = $reqCat->fetch()) {
        // Prévenir l'injection HTML avec htmlspecialchars
        $cityName = htmlspecialchars($cat['Name']);
        $options .= '<option value="' . $cityName . '">' . $cityName . '</option>';
    }

    return $options;
}
function getNbrPlaceLibre() {
	// We connect to the database.
	$database = getBdd();
    $sql3 = "SELECT SUM(AvailablePlaces) AS total FROM Parking";

	$result3 = $database->query($sql3);
	$row = $result3->fetch(PDO::FETCH_ASSOC); // Utilisation correcte de PDO

    if ($row) {
        return $row['total'];
    } else {
        return "Aucune donnée trouvée.";
    }
};
function getNbrPlaceTotal() {
	// We connect to the database.
	$database = getBdd();
    $sql3 = "SELECT SUM(TotalPlace) AS total FROM Parking";

	$result3 = $database->query($sql3);
	$row = $result3->fetch(PDO::FETCH_ASSOC); // Utilisation correcte de PDO

    if ($row) {
        return $row['total'];
    } else {
        return "Aucune donnée trouvée.";
    }
};
function getNbrParking($s) {
	// We connect to the database.
	$database = getBdd();
    $result5 = $database->query("SELECT count(Location) AS nombre FROM Parking WHERE StateUp=$s");
    $row = $result5->fetch(PDO::FETCH_ASSOC); // Utilisation correcte de PDO
    if ($row) {
        return $row['nombre'];
    } else {
        return "Aucune donnée trouvée.";
    }
};

function getOccupedPlaces(){
    $occuped_place = getNbrPlaceTotal()-getNbrPlaceLibre();
    return $occuped_place;
};
function getOccupedPlaces(){
    $occuped_place = getNbrPlaceTotal()-getNbrPlaceLibre();
    return $occuped_place;
};
function getNbrTrafficLight($s) {
	// We connect to the database.
	$database = getBdd();
    $result5 = $database->query("SELECT count(IdTrafficLight) AS nombre FROM trafficlight WHERE StateUp=$s");
    $row = $result5->fetch(PDO::FETCH_ASSOC); // Utilisation correcte de PDO
    if ($row) {
        return $row['nombre'];
    } else {
        return "Aucune donnée trouvée.";
    }
};