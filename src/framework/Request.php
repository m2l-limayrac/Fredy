<?php

/*
 * Classe modélisant une requête HTTP entrante
 * Elle contient tout ce qui passe en GET, POST ainsi que les noms du contrôleur et de l'action en cours
 * @author J.F. Ramiara
 */

class Request {

  private $params=array(); // Tableau des paramètres de la requête HTTP

  // Pas de constructeur dans une classe statique !

  
  
  /**
   * Ajoute un paramètre dans la requête HTTP
   * @param string $key
   * @param mixed $value
   */
  public function set($key, $value) {
    $this->params[$key] = $value;
  }

  /**
   * Indique si un paramètre existe dans la requête HTTP
   * @param string $key
   * @return boolean true = le paramètre existe
   */
  public function exists($key)  {
    return isset($this->params[$key]);
  }

  /**
   * Renvoie la valeur d'un paramètre de la requête HTTP
   * @param string $key Nom du paramètre
   * @param string $defaut Valeur à renvoyer par défaut
   * @return string Valeur du paramètre
   */
  public function get($key, $defaut = null) {
    if (isset($this->get_params()[$key])) {
      $valeur = $this->get_params()[$key];
    } else {
      $valeur = $defaut;
    }
    return $valeur;
  }

  /**
   * Initialise le tableau des paramètres de la requête HTTP
   * @param array $params
   */
  public function set_params(array $params) {
    $this->params = $params;
  }
 
  /**
   * Renvoie le tableau des paramètres de la requête HTTP
   * @return array Tableau des paramètres
   * @throws Exception Si aucun fichier de configuration n'est trouvé
   */
  private function get_params() {
    return $this->params;
  }

}

// classe Request 
