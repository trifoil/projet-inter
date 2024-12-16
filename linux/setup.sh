#!/bin/bash

clear

RED='\033[0;31m'
BLUE='\e[38;5;33m'
NC='\033[0m'

updatedb
systemctl enable --now cockpit.socket
firewall-cmd --permanent --zone=public --add-service=cockpit
firewall-cmd --reload
dnf -y install nfs-utils samba bind chrony fail2ban vsftpd rsync clamav clamd clamav-update bind-utils httpd php php-mysqlnd mariadb-server phpmyadmin mod_ssl

clear

display_menu() {
echo ""
    echo "|----------------------------------------------------------------------|"
    echo -e "|                 ${BLUE}Welcome to the server assistant ${NC}                     |"
    echo "|              Please select the tool you want to use                  |"
    echo "|----------------------------------------------------------------------|"
    echo "| 0. Setup                                                             |"
    echo "|----------------------------------------------------------------------|"
    echo "| q. Quit                                                              |"
    echo "|----------------------------------------------------------------------|"
    echo ""
}

prompt() {
  local prompt_message=$1
  local default_value=$2
  read -p "$prompt_message [$default_value]: " input
  echo "${input:-$default_value}"
}

set_dns_server() {
    read -p "Enter the DNS server IP: " DNS_SERVER_IP
    echo "nameserver $DNS_SERVER_IP" > /etc/resolv.conf
    echo "DNS server set to $DNS_SERVER_IP"
}

basic_root_website(){
    DOMAIN_NAME=$1
    dnf -y install httpd mod_ssl
    mkdir -p /mnt/raid5_web/root
    echo "<html><body><h1>Welcome to $DOMAIN_NAME</h1></body></html>" > /mnt/raid5_web/root/index.php
    chown -R apache:apache /mnt/raid5_web/root
    chcon -R --type=httpd_sys_content_t /mnt/raid5_web/root
    chmod -R 755 /mnt/raid5_web/root
    cat <<EOL > /etc/httpd/conf.d/root.conf
<VirtualHost *:80>
    ServerName $DOMAIN_NAME
    ServerAlias *.$DOMAIN_NAME
    DocumentRoot /mnt/raid5_web/root
    <Directory /mnt/raid5_web/root>
        AllowOverride All
        Require all granted
    </Directory>
    DirectoryIndex index.php
    ErrorLog /var/log/httpd/root_error.log
    CustomLog /var/log/httpd/root_access.log combined

    # Redirect all traffic to HTTPS
    Redirect "/" "https://$DOMAIN_NAME/"
</VirtualHost>
EOL

    # Generate a wildcard self-signed SSL certificate
    mkdir -p /etc/httpd/ssl
    openssl req -new -newkey rsa:2048 -days 365 -nodes -x509 \
        -keyout /etc/httpd/ssl/$DOMAIN_NAME.key \
        -out /etc/httpd/ssl/$DOMAIN_NAME.crt \
        -subj "/C=US/ST=State/L=City/O=Organization/OU=Department/CN=*.$DOMAIN_NAME"

    # Set up the virtual host for HTTPS
    cat <<EOL > /etc/httpd/conf.d/root-ssl.conf
<VirtualHost *:443>
    ServerName $DOMAIN_NAME
    ServerAlias *.$DOMAIN_NAME
    DocumentRoot /mnt/raid5_web/root
    <Directory /mnt/raid5_web/root>
        AllowOverride All
        Require all granted
    </Directory>
    DirectoryIndex index.php
    SSLEngine on
    SSLCertificateFile /etc/httpd/ssl/$DOMAIN_NAME.crt
    SSLCertificateKeyFile /etc/httpd/ssl/$DOMAIN_NAME.key
    ErrorLog /var/log/httpd/root_ssl_error.log
    CustomLog /var/log/httpd/root_ssl_access.log combined
</VirtualHost>
EOL

    # Start and enable the Apache HTTP server
    systemctl start httpd
    systemctl enable httpd
    systemctl restart httpd
    firewall-cmd --add-service=http --permanent
    firewall-cmd --add-service=https --permanent
    firewall-cmd --reload
    echo "Verifying HTTP Access..."
    curl -I http://$DOMAIN_NAME
    echo "Verifying HTTPS Access..."
    curl -I https://$DOMAIN_NAME
}

basic_db(){
    DOMAIN_NAME=$1
    dnf -y install mariadb-server phpmyadmin
    systemctl start mariadb
    systemctl enable mariadb
    mysql_secure_installation <<EOF

y
rootpassword
rootpassword
y
y
y
y
EOF

    # Create admin user and grant all privileges
    mysql -u root <<EOF
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'Test123*';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
EOF

    firewall-cmd --add-service=mysql --permanent
    firewall-cmd --reload
    ln -s /usr/share/phpmyadmin /mnt/raid5_web/root/phpmyadmin
    conf_file="/etc/httpd/conf.d/phpMyAdmin.conf"

cat <<EOL > $conf_file
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

    systemctl restart httpd
    echo "Configuration updated and Apache restarted."
    ausearch -c 'mariadbd' --raw | audit2allow -M my-mariadbd
    semodule -X 300 -i my-mariadbd.pp
    echo "<html><body><h1>PHPMyAdmin installed. <a href='/phpmyadmin'>Access it here</a></h1></body></html>" > /mnt/raid5_web/root/index.php
    systemctl restart httpd
}

setup_all(){
    read -p "Enter the domain name (e.g., transport.smartcity.lan): " DOMAIN_NAME
    set_dns_server
    basic_root_website $DOMAIN_NAME
    basic_db $DOMAIN_NAME
    echo "Press any key to continue..."
    read -n 1 -s key
}

main() {
    while true; do
        # clear
        display_menu
        read -p "Enter your choice: " choice
        case $choice in
            0) setup_all ;;
            q|Q) clear && echo "Exiting the web server configuration wizard." && exit ;;
            *) clear && echo "Invalid choice. Please enter a valid option." ;;
        esac
    done
}

main
