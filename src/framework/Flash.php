<?php

/**
 * Classe Flash
 * Gère des messages qui s'affichent sur la page web qui suit celle où les messages sont générés
 * Le principe est de stocker les messages en session puis de les dépiler dans la page suivante
 * Quand un message est affiché, il est en même temps supprimé de la session
 * On peut stocker plusieurs messages avant de les afficher
 * @author jef
 */
class Flash {

  /**
   * Initialise les messages flash
   */
  static function reset() {
    $_SESSION['flashes'] = array();
  }

  /**
   * Ajoute un message flash
   * @param type $message
   * @param type $level
   */
  static function add($message, $level = 1) {
    $_SESSION['flashes'][] = array('message' => $message, 'level' => $level);
  }

  /**
   * Affiche les les messages flash au format HTML
   * @return string
   */
  static function show() {
    $flashes = self::get();
    $html = '';
    foreach ($flashes as $flash) {
      switch ($flash['level']) {
        case 0:
          $class = 'debug';
          break;
        case 1:
          $class = 'info';
          break;
        case 2:
          $class = 'warning';
          break;
        case 3:
          $class = 'error';
          break;
        case 4:
          $class = 'fatal';
          break;
        default:
          $class = 'info';
          break;
      }
      $html .= '<div class="' . $class . '">' . nl2br($flash['message']) . '</div>';
    }
    return $html;
  }

  /**
   * Retourne les messages flash et les supprime de la session
   * @return type
   */
  static function get() {
    if (isset($_SESSION['flashes'])) {
      $copy = $_SESSION['flashes'];
      unset($_SESSION['flashes']);
      return $copy;
    } else {
      return array();
    }
  }

}

// class Flash
