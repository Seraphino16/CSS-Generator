# CSS Generator

Le CSS Generator est le premier projet que j'ai réalisé à Epitech.

## Objectif

Le but du projet est de créer un générateur de sprite CSS en PHP qui :
 - prends en entrée un dossier
 - crée un sprite contenant toutes les images .png dans ce dossier
 - crée un fichier css permettant d'utiliser le sprite

### Options

Plusieurs options sont possibles :
  - `-r` permet d'activer la récursivité
  - `-i` permet de choisir le nom de l'image générée
  - `-s` permet de choisir le nom du fichier css généré
  - `-h` permet d'afficher l'aide

### Executer le programme

Pour executer le programme :
   - vérifiez l'installation de PHP et de l'extension php-gd ou installez-la.
   
     Exemple sur Ubuntu :
     ```bash
     sudo apt-get install php-gd
     ```
   - exécutez le script PHP
     ```bash
     ./css_generator nom_du_dossier
     ```
