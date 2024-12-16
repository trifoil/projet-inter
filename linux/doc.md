d# Linux

Use : 

```
sudo rm -rf projet-inter
git clone -b linux https://github.com/trifoil/projet-inter.git
cd projet-inter/linux
sudo sh setup.sh
cd .. 
cd ..
```

## Plan de partitionnement 

* /home : 4GB
* /server : 10GB
* / : 20GB
* /boot/efi : 600MB
* /boot : 1024MB
* swap : 8GB

## Implémentation DNS 

```transport.smartcity.lan```


## Fix DB


```
mysql -u root
```
Commande SQL:
```
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'Test123*';
GRANT ALL PRIVILEGES ON *.* TO 'newuser'@'localhost';
FLUSH PRIVILEGES;
```
Commande : 
```
exit
service mysql restart
```