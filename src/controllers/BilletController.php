<?php

/**
 * Controleur Billet
 *
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'Request.php';
require_once SRC . DS . 'framework' . DS . 'Controller.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'framework' . DS . 'Auth.php';
require_once SRC . DS . 'models' . DS . 'Billet.php';
require_once SRC . DS . 'DAO' . DS . 'BilletDAO.php';
require_once SRC . DS . 'DAO' . DS . 'UtilisateurDAO.php';

class BilletController extends Controller {

  /**
   * Action par défaut : affiche la liste des billets
   */
  public function index() {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    // Lecture de tous les billets
    $billetDAO = new BilletDAO();
    $billets = $billetDAO->findAll();
    // Appele la vue 
    $this->show_view('billet/index', array('billets' => $billets));
  }

  /**
   * Détails d'un billet
   */
  public function details($id_billet) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect();
    }
    // Lecture du billet
    $billetDAO = new BilletDAO();
    $billet = $billetDAO->find($id_billet);
    // Lecture de l'utilisateur associé au billet
    $utilisateurDAO = new UtilisateurDAO();
    $utilisateur = $utilisateurDAO->find(1);  // Temporaire
    // Appele la vue 
    $this->show_view('billet/details', array(
        'billet' => $billet,
        'utilisateur' => $utilisateur,
    ));
  }

  /**
   * Ajoute un billet
   */
  public function ajouter() {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      $billet = new Billet(array(
          'titre' => $this->request->get('titre'),
          'contenu' => $this->request->get('contenu')
      ));
      $billetDAO = new BilletDAO();
      $nb = $billetDAO->insert($billet);
      if ($nb != 0) {
        Flash::add("Billet ajouté !");
      }
    } else {
      $billet = new Billet();
    }
    // Lecture du billet
    // Appele la vue 
    $this->show_view('billet/ajouter', array('billet' => $billet,
        'action' => 'billet/ajouter'));
  }

  /**
   * Modifie un billet
   * @param int $id_billet
   */
  public function modifier($id_billet=null) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      $id_billet = $this->request->get('id_billet');
      $billet = new Billet(array(
          'id_billet' => $id_billet,
          'titre' => $this->request->get('titre'),
          'contenu' => $this->request->get('contenu')
      ));
      $billetDAO = new BilletDAO();
      $nb = $billetDAO->update($billet);
      if ($nb != 0) {
        Flash::add("Billet modifié !");
      }
    }
    // Lecture du billet
    $billetDAO = new BilletDAO();
    $billet = $billetDAO->find($id_billet);
    // Appele la vue 
    $this->show_view('billet/ajouter', array('billet' => $billet,
        'action' => 'billet/modifier'));
  }

  /**
   * Ajoute un commentaire à un billet
   */
  public function commenter($id_billet = null) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      // Commentaire saisi, on récupère les données du formulaire
      $id_billet = $this->request->get('id_billet');
      $commentaire = new Commentaire(array(
          'id_billet' => $id_billet,
          'id_utilisateur' => 1, // Temporaire
          'contenu' => $this->request->get('contenu')
      ));
      // Ajout du commentaire dans la base
      $commentaireDAO = new CommentaireDAO();
      $nb = $commentaireDAO->insert($commentaire);
      // Message de confirmation
      if ($nb != 0) {
        Flash::add("Commentaire ajouté !");
      }
    } else {
      // Commentaire pas encore saisi, on initialise le formulaire
      $commentaire = new Commentaire();
      $commentaire->set_id_billet($id_billet);
    }
    $billetDAO = new BilletDAO();
    $billet = $billetDAO->find($id_billet);
    // Appele la vue 
    $this->show_view('billet/commenter', array(
        'billet' => $billet,
        'commentaire' => $commentaire,
        'action' => 'billet/commenter'
    ));
  }

}
