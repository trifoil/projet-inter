#!/bin/bash

# Update the system
sudo dnf update -y

# Install Apache
sudo dnf install httpd -y
sudo systemctl start httpd
sudo systemctl enable httpd

# Install PHP and necessary modules
sudo dnf install php php-mysqlnd php-fpm -y
sudo systemctl restart httpd

# Install MariaDB
sudo dnf install mariadb-server mariadb -y
sudo systemctl start mariadb
sudo systemctl enable mariadb

# Secure MariaDB installation
sudo mysql_secure_installation <<EOF

y
a
a
y
y
y
y
EOF

# Create a database and user
sudo mysql -u root <<EOF
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'Test123*';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
EXIT;
EOF

# Create a PHP test file
cat <<EOF | sudo tee /var/www/html/info.php
<?php
phpinfo();
?>
EOF

# Restart Apache to apply changes
sudo systemctl restart httpd

# Output completion message
echo "Setup complete."

# Clean up
sudo rm /var/www/html/info.php