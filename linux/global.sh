#!/bin/bash

# Update the system
sudo dnf update -y

# Install MariaDB server and client
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

# Install Python and Pip
sudo dnf install python3 python3-pip -y

# Install Django
pip3 install django

# Create Django project
django-admin startproject projinter

# Install MariaDB development packages
sudo dnf install mariadb-devel -y
sudo dnf install python3-devel -y
pip install mysql-connector-python
sudo dnf install gcc gcc-c++ python3-devel mysql-devel redhat-rpm-config libffi-devel openssl-devel --skip-broken

# Install mysqlclient
pip3 install mysqlclient

# Variables
PROJECT_NAME="projinter"
DB_NAME="dbcommune"
DB_USER="admin"
DB_PASSWORD="Test123*"
DB_HOST="localhost"
DB_PORT="3306"

# Backup the original settings.py file
cp $PROJECT_NAME/settings.py $PROJECT_NAME/settings.py.bak

# Edit the settings.py file
cat <<EOL > $PROJECT_NAME/settings.py
# Original settings.py content
$(cat $PROJECT_NAME/settings.py.bak)

# Database configuration
DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'NAME': '$DB_NAME',
        'USER': '$DB_USER',
        'PASSWORD': '$DB_PASSWORD',
        'HOST': '$DB_HOST',
        'PORT': '$DB_PORT',
    }
}
EOL

# Remove the backup file
rm $PROJECT_NAME/settings.py.bak

echo "Database configuration updated successfully."

# Create the database and user in MariaDB
sudo mysql -u root -prootpassword <<EOF
CREATE DATABASE $DB_NAME;
CREATE USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF

# Run Django migrations
python3 projinter/manage.py migrate

# Create a superuser
python3 projinter/manage.py createsuperuser

sudo firewall-cmd --add-port=8000/tcp --permanent
sudo firewall-cmd --add-port=3306/tcp --permanent
sudo firewall-cmd --reload


# Path to your Django project's settings.py file
SETTINGS_FILE="$PROJECT_NAME/settings.py"

# Use sed to replace ALLOWED_HOSTS = [] with ALLOWED_HOSTS = ['*']
sed -i 's/ALLOWED_HOSTS = \[\]/ALLOWED_HOSTS = ['\''*'\'']/' "$SETTINGS_FILE"

echo "Updated ALLOWED_HOSTS in $SETTINGS_FILE"


# Run the development server (sent to background)
# nohup python3 projinter/manage.py runserver 0.0.0.0:8000 &

echo "Django development server is running at http://localhost:8000"



# # Installing samba share
#     echo "Installing Samba share"
    
#     dnf update -y
#     dnf -y install samba samba-client
#     systemctl enable smb --now
#     systemctl enable nmb --now    

#     firewall-cmd --permanent --add-service=samba
#     firewall-cmd --reload

#     chown -R nobody:nobody /home/admin/projet-inter/linux/
#     chmod -R 0777 /home/admin/projet-inter/linux/
    
#     cat <<EOL > /etc/samba/smb.unauth.conf
# [unauth_share]
#    path = /home/admin/projet-inter/linux/
#    browsable = yes
#    writable = yes
#    guest ok = yes
#    guest only = yes
#    force user = nobody
#    force group = nobody
#    create mask = 0777
#    directory mask = 0777
#    read only = no
# EOL
    
#     PRIMARY_CONF="/etc/samba/smb.conf"
#     INCLUDE_LINE="include = /etc/samba/smb.unauth.conf"

#     if ! grep -Fxq "$INCLUDE_LINE" "$PRIMARY_CONF"; then
#         echo "$INCLUDE_LINE" >> "$PRIMARY_CONF"
#         echo "Include line added to $PRIMARY_CONF"
#     else
#         echo "Include line already exists in $PRIMARY_CONF"
#     fi

#     # SELINUX RAHHHHHHHHHHH
#     /sbin/restorecon -R -v /home/admin/projet-inter/linux/    setsebool -P samba_export_all_rw 1

# setsebool -P httpd_can_network_connect 1

# setsebool -P httpd_graceful_shutdown 1

# setsebool -P httpd_can_network_relay 1

# setsebool -P nis_enabled 1

# setsebool -P samba_export_all_ro 1

# setsebool -P samba_export_all_rw 1

# ausearch -c 'php-fpm' --raw | audit2allow -M my-phpfpm
# semodule -X 300 -i my-phpfpm.pp

#     systemctl restart smb
#     systemctl restart nmb

#     echo "Samba services restarted"

#     echo "Press any key to continue..."
#     read -n 1 -s key
