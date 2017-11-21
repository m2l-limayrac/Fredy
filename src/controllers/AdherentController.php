<?php

/**
 * Controleur des utilisateurs
 *
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'Controller.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'framework' . DS . 'Auth.php';
require_once SRC . DS . 'models' . DS . 'Adherent.php';
require_once SRC . DS . 'DAO' . DS . 'AdherentDAO.php';


class AdherentController extends Controller {

  /**
   * Action par défaut : affiche la liste des utilisateurs
   */
  public function index() {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('adherent/login');
    }
    // Lecture de tous les utilisateurs
    $adherentDAO = new AdherentDAO();
    $adherents = $adherentDAO->findAll();
    // Appele la vue 
    $this->show_view('adherent/index', array('adherents' => $adherents));
  }

  /**
   * Détails d'un utilisateur
   */
  public function details($id_adherent) {
    // Vérifie si l'adherent est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('adherent/login');
    }
    // Lecture du adherent
    $adherentDAO = new AdherentDAO();
    $adherent = $adherentDAO->find($id_adherent);
    // Appele la vue 
    $this->show_view('adherent/details', array(
        'adherent' => $adherent
    ));
  }


  /**
   * Inscrit un utilisateur
   */
  public function register() {
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      // le formulaire est soumis
      $adherent = new Adherent(array(
          'login' => $this->request->get('login'),
          'password' => $this->request->get('password'),
          'is_admin' => $this->request->exists('is_admin')
      ));
      if (Auth::inscrire($adherent)) {
        Flash::add("Vous êtes inscrit !", 1);
      } else {
        Flash::add("Une erreur est survenue lors de l'inscription, veuillez réessayer SVP", 3);
      }
    } else {
      // Le formulaire n'a pas été soumis
      $adherent = new Adherent();
    }

    // Appele la vue 
    $this->show_view('adherent/register', array(
        'adherent' => $adherent,
        'action' => 'adherent/register'
    ));
  }

  /**
   * Connecte un adherent
   */
  public function login() {
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      // le formulaire est soumis
      $adherent = new Adherent(array(
          'login' => $this->request->get('login'),
          'password' => $this->request->get('password')
              )
      );
      if (Auth::connecter($adherent)) {
        Flash::add("Vous êtes connecté !");
      } else {
        Flash::add("Erreur, veuillez réessayer SVP", 3);
      }
    } else {
      // Le formulaire n'a pas été soumis
      $adherent = new Adherent();
    }
    // Appele la vue 
    $this->show_view('adherent/login', array(
        'adherent' => $adherent,
        'action' => 'adherent/login'
    ));
  }

  /**
   * Connecte un adherent
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
