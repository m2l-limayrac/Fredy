# Fredi
## Réalisé par : 
* Alexis Lapeze
* Julien Pinet
* Clement Roussel

## Installation : 
* Récupérer le projet : 
```cmd
git clone https://github.com/m2l-limayrac/Fredy.git
````
* Installer easyPHP 17
* Créé un dossier nommé 'Fredy' dans le dossier eds-www de easyPHP et déplacer le fichier cloner à l'intérieur
* Récuperer le script SQL **fredi_plot3_structure** dans le dossier nommé **'sql'** et l'importer dans MySQL en **désactivant la verification des clés étrangère**
* Récuperer le script SQL **fredi_plot3_data** dans le dossier sql et l'importer dans MySQL en **désactivant la verification des clés étrangère**
* Si vous utilisez EasyPhp, merci de vérifier que mysql est à jour. Sinon :
```cmd
mysql-upgrade.exe -u root --force
```
## Utilisation : 
* Privilégier __**Google Chrome**__ pour lancer le site.
* Login : 'simon.berbier@gmail.com' & 'corentin.diolo@gmail.com'
* Tous les mots de passes sont : '1234'
* Pour modifier le tarrif kilométrique, modifier la valeur de l'année courente dans la table "indemnité"
