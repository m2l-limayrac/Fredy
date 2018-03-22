<?php
//
// top14server - Serveur web service RESTful
//
// fichier commun inclus dans toute les pages

// Racine du site en absolu
//define('ROOT', dirname(dirname(__FILE__)));  // Racine du site en absolu
require_once "../src/config/init.php";
require_once SRC . DS . 'DAO' . DS . 'DemandeurDAO.php';
require_once SRC . DS . 'models' . DS . 'Demandeur.php';
require_once SRC . DS . 'framework' . DS . 'Auth.php';

// inclut les équipe du Top14
//require_once ROOT."API/inc/equipes.inc.php";

// Inclut les fonctions
require_once ROOT. DS . "API". DS ."inc". DS ."fonctions.inc.php";

// Inclut les users à authentifier
//require_once ROOT."API/inc/utilisateurs.inc.php";

 
// Emplacement du fichier des tokens
define("TOKEN_FILENAME",ROOT."API/files/tokens.txt");
