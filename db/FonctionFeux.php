<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "transport_smartcity"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// update aléatoir du temps d'attente des feux
$updateSql = "UPDATE trafficlight SET Affluence = FLOOR(1 + (RAND() * 20))";
if ($conn->query($updateSql) === TRUE) {
    echo "Temps d'attente mis à jour avec succès.<br>";
} else {
    echo "Erreur lors de la mise à jour: " . $conn->error . "<br>";
}

$sql = "SELECT * FROM trafficlight ORDER BY Affluence ASC LIMIT 4";
$result = $conn->query($sql);

$totalAffluence = 0;
$numRows = 0;
$minAffluence = PHP_INT_MAX;
$maxAffluence = PHP_INT_MIN;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $affluence = $row["Affluence"];
        $totalAffluence += $affluence;
        $numRows++;
        
        if ($affluence < $minAffluence) {
            $minAffluence = $affluence;
        }
        
        if ($affluence > $maxAffluence) {
            $maxAffluence = $affluence;
        }
        
        echo "IdTrafficLight: " . $row["IdTrafficLight"]. " - StateUp: " . $row["StateUp"]. " - Affluence: " . $affluence. " minutes<br>";
    }
    
    $averageAffluence = $totalAffluence / $numRows;
    echo "Moyenne Affluence: " . $averageAffluence . " minutes<br>";
    echo "Plus_court Affluence: " . $minAffluence . " minutes<br>";
    echo "Plus_longue Affluence: " . $maxAffluence . " minutes<br>";
} else {
    echo "0 results";
}

$conn->close();
?>
