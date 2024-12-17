# Linux

Use : 

```
sudo rm -rf projet-inter
git clone -b linux https://github.com/trifoil/projet-inter.git
cd projet-inter
cd linux
sudo sh setup.sh
cd .. 
cd ..
```


```
git clone https://github.com/trifoil/projet-inter.git
cd projet-inter/linux
sudo sh setup.sh
```

## Plan de partitionnement 

- **`/boot/efi`**:
  - **Size**: 600 MB
  - **Format**: EFI system partition

- **`/boot`**:
  - **Size**: 1024 MB
  - **Format**: ext4

- **`/` (root)**:
  - **Size**: 20 GB
  - **Format**: ext4

- **`/home`**:
  - **Size**: 4 GB
  - **Format**: ext4

- **`/server` (server data)**:
  - **Size**: 10 GB
  - **Format**: xfs

- **`swap`**:
  - **Size**: 8 GB
  - **Format**: swap

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