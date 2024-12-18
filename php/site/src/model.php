<?php 
function getParking($n) {
	// We connect to the database.
	try {
    	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
	} catch(Exception $e) {
    	die('Erreur : '.$e->getMessage());
	}

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

function getNbrParking($s) {
	// We connect to the database.
	try {
    	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
	} catch(Exception $e) {
    	die('Erreur : '.$e->getMessage());
	}
    ;
    $result5 = $database->query("SELECT count(Location) AS nombre FROM Parking WHERE StateUp=$s");
    $row = $result5->fetch(PDO::FETCH_ASSOC); // Utilisation correcte de PDO
    if ($row) {
        return $row['nombre'];
    } else {
        return "Aucune donnée trouvée.";
    }
};
// ---------------- Total des places libres
function getNbrPlaceLibre() {
	// We connect to the database.
	try {
    	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
	} catch(Exception $e) {
    	die('Erreur : '.$e->getMessage());
	}
    ;
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
	try {
    	$database = new PDO('mysql:host=localhost;dbname=transport_smartcity;charset=utf8', 'root', '');
	} catch(Exception $e) {
    	die('Erreur : '.$e->getMessage());
	}
    ;
    $sql3 = "SELECT SUM(TotalPlace) AS total FROM Parking";

	$result3 = $database->query($sql3);
	$row = $result3->fetch(PDO::FETCH_ASSOC); // Utilisation correcte de PDO

    if ($row) {
        return $row['total'];
    } else {
        return "Aucune donnée trouvée.";
    }
};



?>