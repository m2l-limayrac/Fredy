<?php

/**
 * Controleur des utilisateurs
 *
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'Controller.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'framework' . DS . 'Auth.php';
require_once SRC . DS . 'models' . DS . 'Demandeur.php';
require_once SRC . DS . 'DAO' . DS . 'DemandeurDAO.php';

class DemandeurController extends Controller {

  /**
   * Action par défaut : affiche la liste des utilisateurs
   */
  public function index() {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    // Lecture de tous les utilisateurs
    $demandeurDAO = new DemandeurDAO();
    $demandeurs = $demandeurDAO->findAll();
    // Appele la vue 
    $this->show_view('demandeur/index', array('demandeurs' => $demandeurs));
  }

  /**
   * Détails d'un utilisateur
   */
  public function details($id_adherent) {
    // Vérifie si l'demandeur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    // Lecture du demandeur
    $demandeurDAO = new DemandeurDAO();
    $demandeur = $demandeurDAO->find($id_adherent);
    // Appele la vue 
    $this->show_view('demandeur/details', array(
        'demandeur' => $demandeur
    ));
  }

  /**
   * Inscrit un utilisateur
   */
  public function register() {
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      // le formulaire est soumis
      $demandeur = new Demandeur(array(
          'AdresseMail' => $this->request->get('AdresseMail'),
          'MotDePasse' => $this->request->get('MotDePasse'),
      ));
      if (Auth::inscrire($demandeur)) {
        Flash::add("Vous êtes inscrit !", 1);
      } else {
        Flash::add("Une erreur est survenue lors de l'inscription, veuillez réessayer SVP", 3);
      }
    } else {
      // Le formulaire n'a pas été soumis
      $demandeur = new Demandeur();
    }

    // Appele la vue 
    $this->show_view('demandeur/register', array(
        'demandeur' => $demandeur,
        'action' => 'demandeur/register'
    ));
  }

  /**
   * Connecte un demandeur
   */
  public function login() {
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      // le formulaire est soumis
      $demandeur = new Demandeur(array(
          'AdresseMail' => $this->request->get('AdresseMail'),
          'MotDePasse' => $this->request->get('MotDePasse')
              )
      );
      if (Auth::connecter($demandeur)) {
        Flash::add("Vous êtes connecté !");
      } else {
        Flash::add("Erreur, Adresse mail et/ou Mot de passe n'existe pas.", 3);
      }
    } else {
      // Le formulaire n'a pas été soumis
      $demandeur = new Demandeur();
    }
    // Appele la vue 
    $this->show_view('demandeur/login', array(
        'demandeur' => $demandeur,
        'action' => 'demandeur/login'
    ));
  }

  /**
   * Connecte un demandeur
   */
  public function logout() {
    if (Auth::deconnecter()) {
      // TODO : à cette instant, il n'y a plus de session donc ce message ne s'affichera jamais
      Flash::add("Vous êtes déconnecté !");
    } else {
      Flash::add("Erreur, impossible de vous déconnecter", 3);
    }
    // On redirige vers la page d'accueil
    $this->redirect('home/index');
  }

}

// Classe AdherentController
