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
require_once SRC . DS . 'models' . DS . 'Adherent.php';
require_once SRC . DS . 'models' . DS . 'Ligue.php';
require_once SRC . DS . 'models' . DS . 'Adherent.php';
require_once SRC . DS . 'models' . DS . 'LigneFrais.php';
require_once SRC . DS . 'models' . DS . 'Representant.php';
require_once SRC . DS . 'models' . DS . 'MyFPDF.php';
require_once SRC . DS . 'DAO' . DS . 'AdherentDAO.php';
require_once SRC . DS . 'DAO' . DS . 'LigueDAO.php';
require_once SRC . DS . 'DAO' . DS . 'LigneFraisDAO.php';
require_once SRC . DS . 'DAO' . DS . 'MotifDAO.php';
require_once SRC . DS . 'DAO' . DS . 'IndemniteDAO.php';
require_once SRC . DS . 'DAO' . DS . 'ClubDAO.php';
require_once SRC . DS . 'DAO' . DS . 'DemandeurDAO.php';
require_once SRC . DS . 'DAO' . DS . 'RepresentantDAO.php';
require_once SRC . DS . 'DAO' . DS . 'NoteDeFraisDAO.php';



class DemandeurController extends Controller {

  /**
   * Action par défaut : affiche la liste des utilisateurs
   */

  public function index(){}

  public function settings($Id_Demandeur) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    $demandeurDAO = new DemandeurDAO();
    $demandeur = $demandeurDAO->find($Id_Demandeur);
    $clubDAO = new ClubDAO();
    $Clubs = $clubDAO->findAll();

    if ($this->request->exists("submit")) {
      $demandeur->set_AdresseMail($this->request->get('AdresseMail'));
      $demandeur->set_MotDePasse(password_hash($this->request->get('MotDePasse'), PASSWORD_BCRYPT));
      if($demandeur->get_Representant()){
        $demandeur->get_Representant()->set_Nom($this->request->get('Nom'));
        $demandeur->get_Representant()->set_Prenom($this->request->get('Prenom'));
        $demandeur->get_Representant()->set_Rue($this->request->get('Rue'));
        $demandeur->get_Representant()->set_Cp($this->request->get('Cp'));
        $demandeur->get_Representant()->set_Ville($this->request->get('Ville'));
      }else{
        $demandeur->get_Adherent()->set_numLicence($this->request->get('numLicence'));
        $demandeur->get_Adherent()->set_Nom($this->request->get('Nom'));
        $demandeur->get_Adherent()->set_Prenom($this->request->get('Prenom'));
        $demandeur->get_Adherent()->set_Sexe($this->request->get('Sexe'));
        $demandeur->get_Adherent()->set_DateNaissance($this->request->get('DateNaissance'));
        $demandeur->get_Adherent()->set_AdresseAdh($this->request->get('AdresseAdh'));
        $demandeur->get_Adherent()->set_CP($this->request->get('CP'));
        $demandeur->get_Adherent()->set_Ville($this->request->get('Ville'));
        $nomClub = $this->request->get('Club');
        foreach ($Clubs as $club) {
          if($club->get_Nom() == $nomClub){
            $demandeur->get_Adherent()->set_Club($club);
            $demandeur->get_Adherent()->set_Id_Club($club->get_Id_Club());
          }
        }

      }
      $demandeurDAO->update($demandeur);
      Auth::memoriser($demandeur);
      $this->redirect('demandeur/details');

    }else{
    // Lecture de tous les utilisateurs
      // Appele la vue 
      $this->show_view('demandeur/settings', array(
        'demandeur' => $demandeur,
        'Clubs' => $Clubs,
        'action' => 'demandeur/settings/'.$Id_Demandeur
      ));
    }
  }

  public function settingsAdherents($Id_Demandeur) {
    // Vérifie si l'utilisateur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    $demandeurDAO = new DemandeurDAO();
    $demandeur = $demandeurDAO->find($Id_Demandeur);

      // Appele la vue 
      $this->show_view('demandeur/settingsAdherents', array(
        'demandeur' => $demandeur,
        'action' => 'demandeur/settingsAdherents/'.$Id_Demandeur
      ));
  }

  public function add($Id_NoteDeFrais){

    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    // Lecture de tous les utilisateurs
    $ligneFraisDAO = new LigneFraisDAO();
    if ($this->request->exists("submit")) {
      $ligne = new LigneFrais(array(
        'Id_ligne' =>  $this->request->get('Id_ligne'),
        'Date' =>  $this->request->get('Date'),
        'Km' =>  $this->request->get('Km'),
        'CoutPeage' =>  $this->request->get('CoutPeage'),
        'CoutRepas' =>  $this->request->get('CoutRepas'),
        'CoutHebergement' =>  $this->request->get('CoutHebergement'),
        'Trajet' =>  $this->request->get('Trajet'),
        'Annee' => $this->request->get('Annee'),
        'Motif' =>  $this->request->get('Motif')
      ));
      $motifDAO = new MotifDAO();
      $ligne->set_Motif($motifDAO->findIdByName($ligne->get_Motif())->get_Id_Motif());
      //$ligne->set_Annee(substr($ligne->get_Date(), 0, 4));
      /*echo "<pre>";
      print_r($ligne);
      echo "</pre>";*/
      $lastIdLigne = $ligneFraisDAO->insert($ligne);

      $ligne->set_Id_Ligne($lastIdLigne);
      $oldDemandeur = serialize($_SESSION['demandeur']);
      $oldDemandeur = unserialize($oldDemandeur);

      $ligneFraisDAO->insertAvance($oldDemandeur->get_Id_Demandeur(), $ligne->get_Id_Ligne(), $Id_NoteDeFrais);

      $demandeurDAO = new DemandeurDAO();
      $demandeur = $demandeurDAO->find($oldDemandeur->get_Id_Demandeur());
      Auth::memoriser($demandeur);
      $this->redirect('demandeur/details');
     }else{
      $indemniteDAO = new IndemniteDAO();
      $Annee = $indemniteDAO->findYearByCurrentYear();
      $motifDAO = new MotifDAO();
      $les_motifs = $motifDAO->findAll();
      // Appele la vue 
      $this->show_view('demandeur/add', array(
          'les_motifs' => $les_motifs,
          'Annee_actuelle' => $Annee,
          'action' => 'demandeur/add/'.$Id_NoteDeFrais
      ));
     }

  }

   public function addNDF(){

    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    // Lecture de tous les utilisateurs
    $noteDeFraisDAO = new NoteDeFraisDAO();
    $ligneFraisDAO = new LigneFraisDAO();
    if ($this->request->exists("submit")) {
      $Id_NoteDeFrais = $noteDeFraisDAO->insert();
      $ligne = new LigneFrais(array(
        'Id_ligne' =>  $this->request->get('Id_ligne'),
        'Date' =>  $this->request->get('Date'),
        'Km' =>  $this->request->get('Km') ? $this->request->get('Km') : 0,
        'CoutPeage' =>  $this->request->get('CoutPeage') ? $this->request->get('CoutPeage') : 0,
        'CoutRepas' =>  $this->request->get('CoutRepas') ? $this->request->get('CoutRepas') : 0,
        'CoutHebergement' =>  $this->request->get('CoutHebergement') ? $this->request->get('CoutHebergement') : 0,
        'Trajet' =>  $this->request->get('Trajet'),
        'Motif' =>  $this->request->get('Motif')
      ));
      $motifDAO = new MotifDAO();
      $ligne->set_Motif($motifDAO->findIdByName($ligne->get_Motif())->get_Id_Motif());
      $ligne->set_Annee(substr($ligne->get_Date(), 0, 4));
      /*echo "<pre>";
      print_r($ligne);
      echo "</pre>";*/
      $lastIdLigne = $ligneFraisDAO->insert($ligne);

      $ligne->set_Id_Ligne($lastIdLigne);
      $oldDemandeur = serialize($_SESSION['demandeur']);
      $oldDemandeur = unserialize($oldDemandeur);

      $ligneFraisDAO->insertAvance($oldDemandeur->get_Id_Demandeur(), $ligne->get_Id_Ligne(), $Id_NoteDeFrais);

      $demandeurDAO = new DemandeurDAO();
      $demandeur = $demandeurDAO->find($oldDemandeur->get_Id_Demandeur());
      Auth::memoriser($demandeur);
      $this->redirect('demandeur/details');
     }else{
      $indemniteDAO = new IndemniteDAO();
      $Annee = $indemniteDAO->findYearByCurrentYear();
      $motifDAO = new MotifDAO();
      $les_motifs = $motifDAO->findAll();
      // Appele la vue 
      $this->show_view('demandeur/addNDF', array(
          'les_motifs' => $les_motifs,
          'Annee_actuelle' => $Annee,
          'action' => 'demandeur/addNDF'
      ));
     }
  }

  public function details() {
    // Vérifie si l'demandeur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    // Lecture du demandeur
    /*$demandeurDAO = new DemandeurDAO();
    $demandeur = $demandeurDAO->find($demandeur->get_Id_Demandeur());*/
    $demandeur = serialize($_SESSION['demandeur']);
    $demandeur = unserialize($demandeur);
    // Appele la vue 
    $this->show_view('demandeur/details', array(
        'demandeur' => $demandeur
    ));
  }


  public function modif($id_ligne) {
    // Formulaire saisi ?
    if (!Auth::est_authentifie()) {
      $this->redirect('utilisateur/login');
    }
    $ligneFraisDAO = new LigneFraisDAO();
     if ($this->request->exists("submit")) {
      $ligne = new LigneFrais(array(
        'Id_ligne' =>  $this->request->get('Id_ligne'),
        'Date' =>  $this->request->get('Date'),
        'Km' =>  $this->request->get('Km'),
        'CoutPeage' =>  $this->request->get('CoutPeage'),
        'CoutRepas' =>  $this->request->get('CoutRepas'),
        'CoutHebergement' =>  $this->request->get('CoutHebergement'),
        'Trajet' =>  $this->request->get('Trajet'),
        'Motif' =>  $this->request->get('Motif')
      ));
      $motifDAO = new MotifDAO();
      $ligne->set_Motif($motifDAO->findIdByName($ligne->get_Motif())->get_Id_Motif());
      $ligne->set_Annee(substr($ligne->get_Date(), 0, 4));
      /*echo "<pre>";
      print_r($ligne);
      echo "</pre>";*/
      $ligneFraisDAO->update($ligne);

      $oldDemandeur = serialize($_SESSION['demandeur']);
      $oldDemandeur = unserialize($oldDemandeur);

      $demandeurDAO = new DemandeurDAO();
      $demandeur = $demandeurDAO->find($oldDemandeur->get_Id_Demandeur());
      Auth::memoriser($demandeur);
      $this->redirect('demandeur/details');
     }else{
      $ligne = $ligneFraisDAO->find($id_ligne);
      $motifDAO = new MotifDAO();
      $les_motifs = $motifDAO->findAll();
      // Appele la vue 
      $this->show_view('demandeur/modif', array(
          'ligne' => $ligne,
          'les_motifs' => $les_motifs,
          'action' => 'demandeur/modif'
      ));
     }
    
  }

  public function drop_line($id_ligne) {
    // Vérifie si l'demandeur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }

    $ligneFraisDAO = new LigneFraisDAO();
    $ligne = $ligneFraisDAO->find($id_ligne);
    $ligneFraisDAO->delete($ligne);
    $oldDemandeur = serialize($_SESSION['demandeur']);
    $oldDemandeur = unserialize($oldDemandeur);

    $demandeurDAO = new DemandeurDAO();
    $demandeur = $demandeurDAO->find($oldDemandeur->get_Id_Demandeur());
    Auth::memoriser($demandeur);
    $this->redirect('demandeur/details');
  }

  /**
   * Inscrit un utilisateur
   */
  public function register() {
    // Formulaire saisi ?
    $clubDAO = new ClubDAO();
    $Clubs = $clubDAO->findAll();

    if ($this->request->exists("submit")) {
      // le formulaire est soumis
      $MotDePasse = $this->request->get('MotDePasse');
      $isRepresentant = $this->request->get('isRepresentant');
      echo gettype($isRepresentant);
      if($isRepresentant == '0'){
        $isRepresentant = false;
      }
      echo $isRepresentant;
      $demandeur = new Demandeur(array(
          'AdresseMail' => $this->request->get('AdresseMail'),
          'MotDePasse' => $MotDePasse,
          'isRepresentant' => $isRepresentant
      ));

      $demandeurDAO = new DemandeurDAO();
      $demandeur->set_MotDePasse(password_hash($demandeur->get_MotDePasse(), PASSWORD_BCRYPT));
      $demandeur->set_Id_Demandeur($demandeurDAO->insert($demandeur));


      if ($demandeur->get_isRepresentant()) {
        $representant = new Representant(array(
          'Nom' => $this->request->get('NomR'),
          'Prenom' => $this->request->get('PrenomR'),          
          'Cp' => $this->request->get('CpR'),
          'Ville' => $this->request->get('VilleR'),
          'id_Demandeur' => $demandeur->get_Id_Demandeur(),
          'Rue' => $this->request->get('RueR')
        ));

        $representantDAO = new RepresentantDAO();
        $representantDAO->insert($representant);

        $demandeur->set_Representant($representant);
      }else{
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

        $demandeur->set_Adherent($adherent);
      }
      
      $demandeur->set_MotDePasse($MotDePasse);
      if (Auth::connecter($demandeur)) {

        Flash::add("Vous êtes inscrit !", 1);
        if ($demandeur->get_isRepresentant()) {
          $this->redirect('adherent/ajout');
        }else{
          $this->redirect('demandeur/details');
        }
      } else {
        Flash::add("Une erreur est survenue lors de l'inscription, veuillez réessayer SVP", 3);
        $this->show_view('demandeur/register', array(
          'demandeur' => $demandeur,
          'Clubs' => $Clubs,
          'action' => 'demandeur/register'
        ));
      }
    } else {
      // Le formulaire n'a pas été soumis
      $demandeur = new Demandeur();
      $this->show_view('demandeur/register', array(
          'demandeur' => $demandeur,
          'Clubs' => $Clubs,
          'action' => 'demandeur/register'
      ));
    }
  }

  /**
   * Connecte un demandeur
   */
  public function login() {
    // Formulaire saisi ?
    $demandeurDAO = new DemandeurDAO();
    $adherentDAO = new AdherentDAO();
    if ($this->request->exists("submit")) {
      // le formulaire est soumis
      $demandeur = $demandeurDAO->findAllByMail($this->request->get('AdresseMail'));
      /*$demandeur = new Demandeur(array(
          'AdresseMail' => $this->request->get('AdresseMail'),
          'MotDePasse' => $this->request->get('MotDePasse')
              )
      );*/
      $demandeur->set_MotDePasse($this->request->get('MotDePasse'));
      //$adherent = $adherentDAO->findByDemandeur($demandeur->get_Id_Demandeur());
      if (Auth::connecter($demandeur)) {
        Flash::add("Vous êtes connecté !");
        /*$this->show_view('demandeur/details', array(
          'demandeur' => $demandeur,
          'adherent' => $adherent,
          'action' => 'demandeur/details'
        ));*/
        $this->redirect('demandeur/details');
      } else {
        Flash::add("Erreur, Adresse mail et/ou Mot de passe n'existe pas.", 3);
        $this->show_view('demandeur/login', array(
          'demandeur' => $demandeur,
          //'adherent' => $adherent,
          'action' => 'demandeur/login'
        ));
      }
    } else {
      // Le formulaire n'a pas été soumis
      $demandeur = new Demandeur();
      $adherent = new Adherent();
      $this->show_view('demandeur/login', array(
        'demandeur' => $demandeur,
        //'adherent' => $adherent,
        'action' => 'demandeur/login'
    ));
    }
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

  public function ndf_pdf($Id_demandeur) {
    // Vérifie si l'demandeur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }

    








    //$this->redirect('demandeur/details');
  }


}

// Classe AdherentController
