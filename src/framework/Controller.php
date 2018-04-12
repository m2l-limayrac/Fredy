<?php

/**
 * Classe mère Contrôleur
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'Request.php';
require_once SRC . DS . 'framework' . DS . 'Controller.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';

abstract class Controller {

  private $controller_name;   // Nom du contrôleur
  private $action_name = '';  // Nom de l'action
  protected $request;  // Paramètres passés en GET et POST

  // Getter et setter

  function get_controller_name() {
    return $this->controller_name;
  }

  function get_action_name() {
    return $this->action_name;
  }

  function get_request() {
    return $this->request;
  }

  function set_controller_name($controller_name) {
    $this->controller_name = $controller_name;
  }

  function set_action_name($action_name) {
    $this->action_name = $action_name;
  }

  function set_request(Request $request) {
    $this->request = $request;
  }

  /**
   * Méthode abstraite pour forcer l'implémentation de l'action par défaut
   */
  public abstract function index();

  /**
   * Construit et affiche la vue
   * @param type $view
   * @param type $data
   */
  public function show_view($view, $data = []) {
    // Génère la partie spécifique de la vue
    $content = $this->expand($view, $data);
    // Génère le template
    $page = $this->expand("template/main", array("content" => $content));
    // Affiche la page dans le navigateur
    echo $page;
  }

  /**
   * Génère une vue à partir de son template et de ses données
   * @param string $view le nom de la vue de la vue (avec son répertoire)
   * @param array $data les données qui sont à insérer dans la vue sous forme de tableau
   * @return string la vue au format HTML
   * @throws Exception
   */
  public function expand($view, $data = []) {
    if (!file_exists(SRC . DS . 'views/' . $view . '.php')) {
      throw new Exception("Erreur, la vue " . $view . " n'existe pas");
    }
    // Convertit le tableau en variables
    extract($data);
    // Bufferise la vue
    ob_start();
    require_once SRC . DS . 'views/' . $view . '.php';
    $html = ob_get_clean();
    // Retourne la vue au format HTML
    return $html;
  }

  /**
   * Fait une redirection
   * Si le chemin n'est pas précisé, on retourne à la page d'accueil
   * @param string $path le chemin sous la forme "contrôleur/action"
   */
  public function redirect($path = null) {
    if ($path != null) {
      $url = BASEURL . '/' . $path;
    } else {
      $url = BASEURL . '/Home/index';
    }
    header('Location: ' . $url);
    exit; // Obligatoire sinon PHP continue à s'exécuter avant de réaliser la redirection
  }

}
