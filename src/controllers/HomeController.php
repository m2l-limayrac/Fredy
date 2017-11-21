<?php

/**
 * Controleur par défaut
 *
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'Controller.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'framework' . DS . 'Auth.php';

class HomeController extends Controller {

  /**
   * Action par défaut
   */
  public function index() {
    // Appele la vue 
    $this->show_view('home/index');
  }

}
