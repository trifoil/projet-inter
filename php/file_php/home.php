<?php include '../src/model.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCity Transport</title>
    <link rel="stylesheet" href="../style/styles.css">
</head>
<body>

    <div class="container">
        <div class="sidebar">
            <h1>Smartcity</h1>
            <h2>Transport</h2>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>State</h1>
                <p>Everything is fine. There are no transportation issues at this time.</p>
            </div>

            <div class="status-section">
                <div class="status-box">
                    <p>🚦 Lights who are working properly: <?= getNbrTrafficLight(1)?>.</p>
                </div>
                <div class="status-box">
                    <p>🚦 Lights who aren't working properly : <?= getNbrTrafficLight(0)?>.</p>
                </div>
            </div>

            <div class="status-section">
                <div class="status-box">
                    <p>🚙 There are currently <?= getOccupedPlaces()?> cars parked.</p>
                </div>
                <div class="status-box">
                   <a href="gestion.php"> <button class="add-carpark">Admin Page !</button></a>
                </div>
            </div>

            <!-- Parking Details -->
            <div class="parking-section">
                <h3>The different car parks in SmartCity Enable:</h3>
                <ul>
                    <?php
                        foreach (getParking(1) as $pe) {
                                echo '<li>',$pe['Location'],' : ', $pe['AvailablePlaces'], ' places restantes sur ',$pe['TotalPlace'],'</li>';}
                    ?>
                </ul>
                <h3>The different car parks in SmartCity Disable:</h3>
                <ul>
                    <?php
                        foreach (getParking(0) as $pd) {
                            echo '<li>',$pd['Location'];}
                    ?>
                </ul>
        	</div>
            <div class="parking-section">
                <h3>The different traffic light enable in SmartCity:</h3>
                    <ul>
                        <?php
                            foreach (getTrafficLight(1) as $tl_e) {
                                    echo '<li>',$tl_e['Name'],' : ', $tl_e['Location'], ' waiting time : ',$tl_e['Affluence'],'min</li>';}
                        ?>
                    </ul>
            </div>
            <div class="parking-section">
                <h3>The different light disable in SmartCity :</h3>
                    <ul>
                        <?php
                            foreach (getTrafficLight(0) as $tl_d) {
                                    echo '<li>',$tl_d['Location'],$tl_d['Name'], 'waiting time x';}
                        ?>
            </div>
        </div>
        <!-- Disconnect -->
        <div class="disconnect">
           <a href="/Loggin/login.html"> <p>USER X <span>🔌 Disconnect</span></p></a>
        </div>
    </div>
</body>
</html>
