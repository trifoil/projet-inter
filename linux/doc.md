# Linux

Utilisation : 

```
sudo rm -rf projet-inter
git clone -b linux https://github.com/trifoil/projet-inter.git
cd projet-inter
cd linux
sudo sh setup.sh
cd .. 
cd ..
```

pour le partage :

```
sudo rm -rf projet-inter
git clone -b linux https://github.com/trifoil/projet-inter.git
cd projet-inter
cd linux
sudo sh samba.sh
cd .. 
cd ..
```

pour le global :

```
sudo rm -rf projet-inter
git clone -b linux https://github.com/trifoil/projet-inter.git
cd projet-inter
cd linux
sudo sh global.sh
cd .. 
cd ..
```

## Plan de Partitionnement

- **`/boot/efi`**:
  - **Taille**: 600 MB
  - **Format**: Partition de système EFI
  - **Type**: Partition standard

- **`/boot`**:
  - **Taille**: 1024 MB
  - **Format**: ext4
  - **Type**: Partition standard

- **`/` (root)**:
  - **Taille**: 20 GB
  - **Format**: ext4
  - **Type**: LVM

- **`/home`**:
  - **Taille**: 4 GB
  - **Format**: ext4
  - **Type**: LVM

- **`/server` (données du serveur)**:
  - **Taille**: 10 GB
  - **Format**: xfs
  - **Type**: LVM

- **`/db` (données de la base de données)**:
  - **Taille**: 10 GB
  - **Format**: xfs
  - **Type**: LVM

- **`/website` (données du site web)**:
  - **Taille**: 5 GB
  - **Format**: ext4
  - **Type**: LVM

- **`swap`**:
  - **Taille**: 8 GB
  - **Format**: swap
  - **Type**: LVM

### Raisons des Choix

1. **ext4**:
   - **Fiabilité et Performance**:
      - système de fichiers mature
      - stable, offrant de bonnes performances
      - grande fiabilité grâce à son journaling
      - rétrocompatible avec ext3 et ext2 (mise à jour simplifiées)
   - **Support Large**:
      - Supporte de grands fichiers et systèmes de fichiers (idéal pour les partitions root, home, et website).

2. **xfs**:
   - **Performance Spécifique**: XFS est optimisé pour les performances :
      - notamment pour les fichiers volumineux et
      - les charges de travail intensives en E/S, ce qui en fait un bon choix pour les données du serveur et de la base de données.

3. **LVM (Logical Volume Manager)**:
   - **Flexibilité**: 
      - permet de redimensionner les volumes logiques à la volée, 
      - facilite la gestion et l'extension du stockage.
   - **Gestion Simplifiée**: 
      - simplifie la gestion du stockage en permettant de créer, supprimer et redimensionner des volumes logiques sans affecter le stockage physique.
   - **Performance et Fiabilité**: 
      - supporte les snapshots pour les sauvegardes et 
      - peut être utilisé avec RAID pour la redondance et la tolérance aux pannes.

### Conclusion

- **ext4**: Idéal pour les systèmes de fichiers généraux nécessitant une grande fiabilité et une performance équilibrée.
- **XFS**: Préféré pour les systèmes de fichiers nécessitant des performances élevées, notamment pour les charges de travail intensives en E/S et les fichiers volumineux.

Ce plan de partitionnement assure que le système est flexible, gérable et peut facilement s'adapter aux besoins futurs en stockage, y compris pour les données de la base de données et du site web.


## Plan de sauvegarde

1. **Avant mise à jour système** : ​
    
  * Sauvegarde complète :​
      - Système​
      - DB​
      - Site​

  * Utilisation de rsync, manuellement ou liée à la mise à jour (ex : alias "safeupdate")​

2. **Chaque jour** : ​
    - Sauvegarde fichiers DB ​
    - Sauvegarde fichiers site web​

  * Utilisation de crontab et rsync​

## Implémentation DNS 

```transport.smartcity.lan```

