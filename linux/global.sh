#!/bin/bash

dnf update -y


sudo dnf install mariadb-server mariadb -y
sudo systemctl start mariadb
sudo systemctl enable mariadb
sudo mysql_secure_installation <<EOF
y
rootpassword
rootpassword
y
y
y
y
EOF

sudo dnf install python3 python3-pip -y
pip3 install django
django-admin startproject myproject
cd myproject
sudo dnf install mariadb-devel -y
pip3 install mysqlclient



# Variables
PROJECT_NAME="myproject"
DB_NAME="dbcommune"
DB_USER="admin"
DB_PASSWORD="Test123*"
DB_HOST="localhost"
DB_PORT="3306"

# Create the Django project if it doesn't exist
if [ ! -d "$PROJECT_NAME" ]; then
    django-admin startproject $PROJECT_NAME
    cd $PROJECT_NAME
else
    cd $PROJECT_NAME
fi

# Backup the original settings.py file
cp settings.py settings.py.bak

# Edit the settings.py file
cat <<EOL > settings.py
# Original settings.py content
$(cat settings.py.bak)

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
rm settings.py.bak

echo "Database configuration updated successfully."

# Edit the myproject/settings.py file to configure the database settings:
# DATABASES = {
#     'default': {
#         'ENGINE': 'django.db.backends.mysql',
#         'NAME': 'dbcommune',
#         'USER': 'admin',
#         'PASSWORD': 'Test123*',
#         'HOST': 'localhost',
#         'PORT': '3306',
#     }
# }


sudo mysql -u root <<EOF
CREATE DATABASE dbcommune;
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'Test123*';
GRANT ALL PRIVILEGES ON dbcommune.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
EOF

python3 manage.py migrate
python3 manage.py createsuperuser
python3 manage.py runserver 0.0.0.0:8000

# http://localhost:8000