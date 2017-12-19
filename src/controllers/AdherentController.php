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
require_once SRC . DS . 'DAO' . DS . 'ClubDAO.php';


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

  public function settings($id_adherent) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    $adherentDAO = new AdherentDAO();
    $adherent = $adherentDAO->find($id_adherent);
    $clubDAO = new ClubDAO();
    $Clubs = $clubDAO->findAll();

    if ($this->request->exists("submit")) {
      $adherent->set_numLicence($this->request->get('numLicence'));
      $adherent->set_Nom($this->request->get('Nom'));
      $adherent->set_Prenom($this->request->get('Prenom'));
      $adherent->set_Sexe($this->request->get('Sexe'));
      $adherent->set_DateNaissance($this->request->get('DateNaissance'));
      $adherent->set_AdresseAdh($this->request->get('AdresseAdh'));
      $adherent->set_CP($this->request->get('CP'));
      $adherent->set_Ville($this->request->get('Ville'));
      $nomClub = $this->request->get('Club');
      foreach ($Clubs as $club) {
        if($club->get_Nom() == $nomClub){
          $adherent->set_Club($club);
          $adherent->set_Id_Club($club->get_Id_Club());
        }
      }

      $adherentDAO->update($adherent);
      
      $demandeur = serialize($_SESSION['demandeur']);
      $demandeur = unserialize($demandeur);

      $demandeur->set_Adherent($adherent);
      Auth::memoriser($demandeur);
      $this->redirect('demandeur/details');

    }else{
    // Lecture de tous les utilisateurs
      // Appele la vue 
      $this->show_view('adherent/settings', array(
        'adherent' => $adherent,
        'Clubs' => $Clubs,
        'action' => 'adherent/settings/'.$id_adherent
      ));
    }
  }
  
  public function delete($id_adherent) {
    // Vérifie si l'demandeur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }

    $adherentDAO = new AdherentDAO();
    $adherentDAO->delete($id_adherent);

    $oldDemandeur = serialize($_SESSION['demandeur']);
    $oldDemandeur = unserialize($oldDemandeur);

    $demandeurDAO = new DemandeurDAO();
    $demandeur = $demandeurDAO->find($oldDemandeur->get_Id_Demandeur());
    Auth::memoriser($demandeur);
    $this->redirect('demandeur/details');
  }


  public function ajout() {
    // Formulaire saisi ?
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    $demandeur = serialize($_SESSION['demandeur']);
    $demandeur = unserialize($demandeur);

    $clubDAO = new ClubDAO();
    $Clubs = $clubDAO->findAll();

    if ($this->request->exists("submit")) {
      // le formulaire est soumis
      $adherent = new Adherent(array(
          'numLicence' => $this->request->get('numLicence'),
          'Nom' => $this->request->get('Nom'),
          'Prenom' => $this->request->get('Prenom'),          
          'Sexe' => $this->request->get('Sexe'),          
          'DateNaissance' => $this->request->get('DateNaissance'),          
          'AdresseAdh' => $this->request->get('AdresseAdh'),          
          'Cp' => $this->request->get('Cp'),
          'Ville' => $this->request->get('Ville'),
          'id_Demandeur' => $demandeur->get_Id_Demandeur(),
          'Id_Club' => $this->request->get('Id_Club')
        ));

        $adherentDAO = new AdherentDAO();
        $adherentDAO->insert($adherent);
        array_push($demandeur->get_Representant()->get_les_adherents(), $adherent);

        if($this->request->get('otherInsert')){
          $this->redirect('adherent/ajout');
        }else{
          Auth::memoriser($demandeur);
          $this->redirect('demandeur/details');
        }

    } else {
      // Le formulaire n'a pas été soumis
      $this->show_view('adherent/ajout', array(
        '$demandeur' => $demandeur,
        'Clubs' => $Clubs,
        'action' => 'adherent/ajout'
    ));
    }
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
