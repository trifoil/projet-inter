
    echo "Installing Samba share"
    sudo mkdir -p /var/www/html/
    
    dnf update -y
    dnf -y install samba samba-client
    systemctl enable smb --now
    systemctl enable nmb --now    

    firewall-cmd --permanent --add-service=samba
    firewall-cmd --reload

    chown -R nobody:nobody /var/www/html/
    chmod -R 0777 /var/www/html/
    
    cat <<EOL > /etc/samba/smb.unauth.conf
[unauth_share]
   path = /var/www/html/
   browsable = yes
   writable = yes
   guest ok = yes
   guest only = yes
   force user = nobody
   force group = nobody
   create mask = 0777
   directory mask = 0777
   read only = no
EOL
    
    PRIMARY_CONF="/etc/samba/smb.conf"
    INCLUDE_LINE="include = /etc/samba/smb.unauth.conf"

    if ! grep -Fxq "$INCLUDE_LINE" "$PRIMARY_CONF"; then
        echo "$INCLUDE_LINE" >> "$PRIMARY_CONF"
        echo "Include line added to $PRIMARY_CONF"
    else
        echo "Include line already exists in $PRIMARY_CONF"
    fi

    # SELINUX RAHHHHHHHHHHH
    /sbin/restorecon -R -v /var/www/html/    setsebool -P samba_export_all_rw 1

setsebool -P httpd_can_network_connect 1

setsebool -P httpd_graceful_shutdown 1

setsebool -P httpd_can_network_relay 1

setsebool -P nis_enabled 1

setsebool -P samba_export_all_ro 1

setsebool -P samba_export_all_rw 1

ausearch -c 'php-fpm' --raw | audit2allow -M my-phpfpm
semodule -X 300 -i my-phpfpm.pp

    systemctl restart smb
    systemctl restart nmb

    echo "Samba services restarted"

    echo "Press any key to continue..."
    read -n 1 -s key
