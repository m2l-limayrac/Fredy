<?php

/**
 * Controleur des commentaires
 *
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'Request.php';
require_once SRC . DS . 'framework' . DS . 'Controller.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'framework' . DS . 'Auth.php';
require_once SRC . DS . 'models' . DS . 'Commentaire.php';
require_once SRC . DS . 'DAO' . DS . 'CommentaireDAO.php';
require_once SRC . DS . 'DAO' . DS . 'UtilisateurDAO.php';

class CommentaireController extends Controller {

  /**
   * Action par défaut : affiche la liste des commentaires
   */
  public function index() {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    // Lecture de tous les commentaires
    $commentaireDAO = new CommentaireDAO();
    $commentaires = $commentaireDAO->findAll();
    // Appele la vue 
    $this->show_view('commentaire/index', array('commentaires' => $commentaires));
  }

  /**
   * Modifie un commentaire
   * @param int $id_commentaire
   */
  public function modifier($id_commentaire = null) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    // Formulaire saisi ?
    if ($this->request->exists("submit")) {
      $id_commentaire = $this->request->get('id_commentaire');
      $commentaire = new Commentaire(array(
          'id_commentaire' => $id_commentaire,
          'id_billet' => $this->request->get('id_billet'),
          'id_utilisateur' => $this->request->get('id_utilisateur'),
          'contenu' => $this->request->get('contenu')
      ));
      $commentaireDAO = new CommentaireDAO();
      $nb = $commentaireDAO->update($commentaire);
      if ($nb != 0) {
        Flash::add("Commentaire modifié !");
      }
    }
    // Lecture du commentaire
    $commentaireDAO = new CommentaireDAO();
    $commentaire = $commentaireDAO->find($id_commentaire);
    // Appele la vue 
    $this->show_view('commentaire/modifier', array('commentaire' => $commentaire,
        'action' => 'commentaire/modifier'));
  }

  public function supprimer($id_commentaire) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }

    $commentaireDAO = new CommentaireDAO();
    $nb = $commentaireDAO->delete($id_commentaire);
    if ($nb != 0) {
      Flash::add("Commentaire supprimé !");
    }
    // Redirection vers la liste des commentaires
    $this->redirect('commentaire/index');
  }

}

// CommentaireController
