
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCity Transport</title>
    <link rel="stylesheet" href="../styles.css">
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
                    <p>🚗 There are currently <span>x</span> cars on the move.</p>
                </div>
                <div class="status-box">
                    <p>🚦 All lights are working properly.</p>
                </div>
            </div>

            <div class="status-section">
                <div class="status-box">
                    <p>🚙 There are currently <span>x</span> cars parked.</p>
                </div>
                <div class="status-box">
                   <a href="templates/gestion.php"> <button class="add-carpark">Add a car park in SmartCity!</button></a>
                </div>
            </div>

            <!-- Parking Details -->
            <div class="parking-section">
                <h3>The different car parks in SmartCity Enable:</h3>
                <ul>
                <?php
    	            foreach ($parking_enable as $pe) {
    	        ?>
                    <ul>
                        <?php
                            echo '<li>',$pe['Location'],' : ', $pe['AvailablePlaces'], ' places restantes sur ',$pe['TotalPlace'],  '<button>+</button></li>';}
                        ?>
                    </ul>
                    <h3>The different car parks in SmartCity Disable:</h3>
                <ul>
                <?php
    	            foreach ($parking_disable as $pd) {
    	        ?>
        	    <div class="parking-section">
                    <ul>
                        <?php
                            echo '<li>',$pd['Location'];}
                        ?>
                    </ul>
        	    </div>
            </div>
        </div>
    </div>
        <!-- Disconnect -->
        <div class="disconnect">
           <a href="/Loggin/login.html"> <p>USER X <span>🔌 Disconnect</span></p></a>
        </div>
    </div>
</body>
</html>