<?php

/**
 * Classe d'authentification et d'autorisation
 *
 * @author jef
 */
require_once SRC . DS . 'DAO' . DS . 'DemandeurDAO.php';
require_once SRC . DS . 'models' . DS . 'Demandeur.php';

class Auth {

  static $demandeurDAO; // Le DAO pour accéder à la table SQL

  /**
   * Pseudo constructeur (voir tout en bas)
   */

  static function init() {
    SELF::$demandeurDAO = new DemandeurDAO();
  }

  /**
   * Inscrit un demandeur
   * @param type $demandeur
   * @return boolean true si l'demandeur est inscrit, false sinon
   */
  static function inscrire(demandeur $demandeur) {
    // Hachage du mot de passe
    $demandeur->set_MotDePasse(password_hash($demandeur->get_MotDePasse(), PASSWORD_BCRYPT));
    SELF::$demandeurDAO->insert($demandeur);
    return true;
  }

  /**
   * Authentifie un demandeur
   * @param type $demandeur
   */
  /*static function connecter(Demandeur $demandeur) {
    print_r($demandeur);
    $ok = true;
    $demandeurs = SELF::$demandeurDAO->findAllByMail($demandeur->get_AdresseMail());
    $demandeur = new Demandeur();
    if (count($demandeurs) == 1) {
      // Demandeur identifié
      $demandeur = $demandeurs;
    }
    if (password_verify($demandeur->get_MotDePasse(), $demandeur->get_MotDePasse())) {
      // Demandeur identifié
      SELF::memoriser($demandeur); // Mémorisation dans la session
      $ok = true;
    } else {
      $ok = false;
    }
    return $ok;
  }*/


  static function connecter(Demandeur $p_demandeur) {
    $ok = true;
    $demandeurs = self::$demandeurDAO->findAllByMail($p_demandeur->get_AdresseMail());
    $demandeur = new Demandeur();
    if (count($demandeurs) == 1) {
      // Demandeur identifié
      $demandeur = $demandeurs;
    }

    if (password_verify($p_demandeur->get_MotDePasse(), $demandeur->get_MotDePasse())) {
      // Demandeur Identifier
      self::memoriser($demandeur); // Mémorisation dans la session
      $ok = true;
    } else {
      $ok = false;
    }
    return $ok;
  }

  /**
   * Déconnecte le demandeur
   * TO DO : ne pas détruire la session complétement car on perd aussi les messages flash !
   */
  static function deconnecter() {
    session_unset(); // Détruit la variable de session
    session_destroy(); // Détruit la session
    setcookie(session_name(), '', -1, '/'); // Détruit le cookie de session
    return true;
  }

  /**
   * Retourne le login de l'demandeur connecté
   * @return string
   */
  static function get_login() {
    if (isset($_SESSION['demandeur'])) {
      $demandeur = $_SESSION['demandeur'];
      $login = $demandeur->get_login();
    } else {
      $login = "inconnu";
    }
    return $login;
  }

  /**
   * Détermine si l'demandeur est authentifié ou pas
   * @param type $login
   * @return boolean true si si l'demandeur est authentifié, false sinon
   */
  static function est_authentifie() {
    $reponse = false;
    if (isset($_SESSION['demandeur'])) {
      $reponse = true;
    } else {
      Flash::add('Vous devez vous connecter pour accéder à cette page', 3);
    }
    return $reponse;
  }

  /**
   * Mémorise en session l'objet correspondant à l'demandeur connecté
   * @param demandeur $demandeur
   */
  static function memoriser(demandeur $demandeur) {
    $_SESSION['demandeur'] = $demandeur;  // Sauvegarde en session
  }

  /**
   * Supprime de la session l'objet correspondant à l'demandeur connecté
   * @param demandeur $demandeur
   */
  static function effacer(demandeur $demandeur) {
    $_SESSION['demandeur'] = $demandeur;  // Sauvegarde en session
  }

}

// class Auth
// Simule un constructeur (Les constructeurs ne marchent pas avec les classes statiques)
Auth::init();
