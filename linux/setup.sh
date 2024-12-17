#!/bin/bash
dnf -y install nfs-utils samba bind chrony fail2ban vsftpd rsync clamav clamd clamav-update bind-utils httpd php php-mysqlnd mariadb-server phpmyadmin mod_ssl

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
rootpassword
rootpassword
y
y
y
y
EOF

cat <<EOL > /etc/httpd/conf.d/phpMyAdmin.conf
# phpMyAdmin - Web based MySQL browser written in php
# 
# Allows only localhost by default
#
# But allowing phpMyAdmin to anyone other than localhost should be considered
# dangerous unless properly secured by SSL

Alias /phpmyadmin /usr/share/phpMyAdmin

<Directory /usr/share/phpMyAdmin/>
    AddDefaultCharset UTF-8

    Require all granted
</Directory>

<Directory /usr/share/phpMyAdmin/setup/>
   Require local
</Directory>

# These directories do not require access over HTTP - taken from the original
# phpMyAdmin upstream tarball
#
<Directory /usr/share/phpMyAdmin/libraries/>
    Require all denied
</Directory>

<Directory /usr/share/phpMyAdmin/templates/>
    Require all denied
</Directory>

<Directory /usr/share/phpMyAdmin/setup/lib/>
    Require all denied
</Directory>

<Directory /usr/share/phpMyAdmin/setup/frames/>
    Require all denied
</Directory>

# This configuration prevents mod_security at phpMyAdmin directories from
# filtering SQL etc.  This may break your mod_security implementation.
#
#<IfModule mod_security.c>
#    <Directory /usr/share/phpMyAdmin/>
#        SecRuleInheritance Off
#    </Directory>
#</IfModule>
EOL

# Create a database and user
sudo mysql -u root <<EOF
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'Test123*';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
EOF

# Exit the MySQL client
echo "exit" | mysql -u root

# Restart the MySQL service
service mysql restart

# Create a PHP test file
touch /var/www/html/info.php
cat <<EOF > /var/www/html/info.php
<?php
echo "bonjour";
?>
EOF

# Configure Apache to listen on all network interfaces
sudo sed -i 's/Listen 80/Listen 0.0.0.0:80/' /etc/httpd/conf/httpd.conf
sudo sed -i 's/Listen 443/Listen 0.0.0.0:443/' /etc/httpd/conf/httpd.conf

# Adjust firewall settings
sudo firewall-cmd --add-service=mysql --permanent
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload

# Restart Apache to apply changes
sudo systemctl restart httpd

# Output completion message
echo "Setup complete."

# Clean up
sudo rm /var/www/html/info.php
