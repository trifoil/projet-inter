<?php 
function getEnablePark() {
	// We connect to the database.
	try {
    	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
	} catch(Exception $e) {
    	die('Erreur : '.$e->getMessage());
	}

	// Get all available parking 
	$statement = $database->query(
    	"SELECT Location, AvailablePlaces, TotalPlace FROM parking WHERE StateUp =1"
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

function getDisablePark() {
	// We connect to the database.
	try {
    	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
	} catch(Exception $e) {
    	die('Erreur : '.$e->getMessage());
	}

	// Get all available parking 
	$statement = $database->query(
    	"SELECT Location, AvailablePlaces, TotalPlace FROM parking WHERE StateUp =0"
	);
	$parking_disable = [];
	while (($row = $statement->fetch())) {
    	$parking = [
        	'Location' => $row['Location'],
        	'AvailablePlaces' => $row['AvailablePlaces'],
        	'TotalPlace' => $row['TotalPlace'],
    	];

    	$parking_disable[] = $parking;
	}

	return $parking_disable;
}

?>