#!/bin/bash

clear


updatedb
dnf -y install nfs-utils samba bind chrony fail2ban vsftpd rsync clamav clamd clamav-update bind-utils httpd php php-mysqlnd mariadb-server phpmyadmin mod_ssl


hostnamectl set-hostname Linux_Serv_TRANSPORT
