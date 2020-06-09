# Installation du projet

## Prérequis

#### Wamp   
#### Composer   
#### Yarn

## Etapes à suivre

* cloner le projet dans le dossier wamp64/www


#### ```git clone https://gitlab.iut-clermont.uca.fr/php-symfony-2019/dealabs-2020/bassinet-fague.git```

* ouvrir un terminal dans le projet et aller dans le dossier dealabs.  
* taper les commandes suivantes : 

#### ```composer install``` 
#### ```yarn install```  
#### ```yarn encore dev```  


* Copier le fichier .env à la racine du projet et le renommer en .env.local  
* Puis, modifier la ligne suivante avec vos informations de base de données :  
  

#### ```DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7```

* Enfin, il faut lancer cette commande afin d'avoir une base de donnée correcte : 

#### ```php bin/console doctrine:migrations:migrate```

