<?php

/**
 * Lance la machine infernale 
 * @author jef
 */
// Lancement de l'application
try {
  // Fichier des constantes
  require_once "../src/config/init.php";  // Ne pas modifier : les constantes SRC et DS n'existent pas encore
  
// Classe de l'application MVC
  require_once SRC.DS.'framework'.DS.'App.php';

  $app = new App();
  // Tests seulement
  /*
  require SRC.DS.'models/Billet.php';
  require SRC.DS.'DAO/BilletDAO.php';
  $billet = new Billet();
  $billetDAO = new BilletDAO();
  $billets = $billetDAO->findAll();
  foreach ($billets as $billet) {
    echo "<p>" . $billet->get_contenu() . "</p>";
  }
  */
} catch (Exception $ex) {
  echo '<!DOCTYPE html>';
  echo '<html lang="fr">';
  echo '<head>';
  echo '<meta charset="UTF-8">';
  echo '<title>'.APPLINAME.' - Erreur générale</title>';
  echo '</head>';
  echo '<body>';
  echo '<h1>'.APPLINAME.'</p>';
  echo "<h2>Erreur générale</h2>";
  echo "<p><strong>Désolé mais l'application s'est arrétée</strong></h2>";
  echo "<pre>Message : " . $ex->getMessage() . "</pre>";
  echo "<pre>Fichier : " . $ex->getFile() . "</pre>";
  echo "<pre>Ligne   : " . $ex->getLine() . "</pre>";
  echo '</body>';
  echo '</html>';
}
