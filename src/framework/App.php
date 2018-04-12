<?php

/**
 * Classe MVC App
 *
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'Request.php';

class App {

  protected $controller_name;       // Nom du contrôleur 
  protected $controller;            // L'objet contrôleur
  protected $action_name = 'index'; // Nom de l'action (ou méthode) 
  protected $params = [];           // Liste des paramètres passés dans l'URL
  protected $request;               // Liste des paramètres passés en GET et POST

  const DEFAULT_CONTROLLER_NAME = 'Home';
  const DEFAULT_ACTION_NAME = 'index';

  /**
   * Constructeur 
   */
  public function __construct() {

    // Parse l'URL
    $url = $this->parse_URL();
    // Détermine le contrôleur
    if (!isset($url[0])) {
      $url[0] = SELF::DEFAULT_CONTROLLER_NAME;
    }
    $this->controller_name = $url[0] . "Controller";

    if (!file_exists(SRC . DS . 'Controllers/' . $this->controller_name . '.php')) {
      throw new Exception("Erreur, le contrôleur " . SRC . DS . 'Controllers/' . $this->controller_name . '.php      ' . $this->controller_name . " n'existe pas");
    }

    // Instancie le contrôleur
    require_once SRC . DS . 'Controllers/' . $this->controller_name . '.php';
    $this->controller = new $this->controller_name;

    // Détermine la méthode
    if (!isset($url[1])) {
      $url[1] = SELF::DEFAULT_ACTION_NAME;
    }
    $this->action_name = $url[1];

    if (!method_exists($this->controller, $this->action_name)) {
      throw new Exception("Erreur, la méthode " . $this->action_name . " n'existe pas");
    }

    // Collecte dans la request tout ce qui est passé en GET et POST + nom du contrôleur + nom de l'action
    $this->request = new Request();
    $this->request->set_params(array_merge($_GET, $_POST));
    $this->request->set('controller', $this->controller_name);
    $this->request->set('action', $this->action_name);

    // Extrait uniquement les paramètres
    $this->params = $url ? array_values($url) : [];
    array_shift($this->params);   // Enlève le nom du contrôleur
    array_shift($this->params);   // Enlève le nom de l'action
    // Fournit au contrôleur les données de base
    $this->controller->set_controller_name($this->controller_name);
    $this->controller->set_action_name($this->action_name);
    $this->controller->set_request($this->request);

    // Appelle la méthode du contrôleur
    // Test
    call_user_func_array(array($this->controller, $this->action_name), $this->params);
  }

  /**
   * Parse l'URL
   * @return string URL parsée sous forme d'un tableau indicé
   */
  public function parse_URL() {
    $tableau = array();
    if (isset($_GET['url'])) {
      $tableau = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
    echo $_GET['url'];
    echo "<pre>";
    print_r($tableau);
    echo "</pre>";
    return $tableau;
  }

}
