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
django-admin startproject myproject
cd myproject

# Install MariaDB development packages
sudo dnf install mariadb-devel -y
sudo dnf install python3-devel -y

# Install mysqlclient
pip3 install mysqlclient

# Variables
PROJECT_NAME="myproject"
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
python3 manage.py migrate

# Create a superuser
python3 manage.py createsuperuser

# Run the development server
python3 manage.py runserver 0.0.0.0:8000

echo "Django development server is running at http://localhost:8000"
