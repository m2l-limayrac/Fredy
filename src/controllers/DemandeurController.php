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

  
  public function ndf_pdf($Id_demandeur, $Id_NoteDeFrais) {
    // Vérifie si l'demandeur est connecté
    if (!Auth::est_authentifie()) {
      $this->redirect('demandeur/login');
    }
    function c($string) {
      return iconv('UTF-8', 'windows-1252', $string);
    }
    $demandeurDAO = new DemandeurDAO();
    $demandeur = $demandeurDAO->find($Id_demandeur);

    foreach ($demandeur->get_les_notes() as $note) { // utiliser l'objet demandeur, pour recuperer la collection des notes 
          if ($note->get_Id_NoteDeFrais() == $Id_NoteDeFrais) {// utiliser la collection des notes de frais Renomé note pour recuperer l'ID de la note de frais de l'objer note pour le comparer a id note de frais passer en parametre 
            $noteDeFrais = $note;//utiliser noteDeFrais hors foreach
          }
        }
    $Annee = $noteDeFrais->get_les_lignes()[0]->get_Annee();
    $indemniteDAO = new IndemniteDAO();
    $indemnite = $indemniteDAO->find($Annee);

    $pdf = new MyFPDF();
    $pdf->AddPage();
    $pdf->setTitle('Note de frais');
    $border = 0;
    $pdf->SetMargins(10, 10, 10, 10);

    //$filename = "note de frais.pdf";//non utiliser probleme a resoudre

    // Titre de page
    $pdf->SetFont ('Arial', 'B', 15);
    $pdf->Cell(70, 10, c("Note de frais des bénévoles"), $border, 1, 'C');
    $pdf->Cell(300, -10, c("Année civile : ". $noteDeFrais->get_les_lignes()[0]->get_Annee()), $border, 1, 'C');
    $pdf->SetFont ('Arial', 'B', 11);
  
    if ($demandeur->get_isRepresentant() == true) {
      $representant = $demandeur->get_Representant();

      $pdf->Cell(28, 35, c("Je sousigné(e)"), $border, 1, 'L');
      $pdf->SetFont ('Arial', '', 11);

      $pdf->ln(-13);
      $pdf->Cell(190, 7, c($representant->get_Nom().' '.$representant->get_Prenom()), 1, 1, 'C');
      $pdf->ln(-13);

      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(21, 35, c("Demeurant"), $border, 1, 'L');
      $pdf->SetFont ('Arial', '', 11);

      $pdf->ln(-13);
      $pdf->Cell(190, 7, c($representant->get_rue().' '.$representant->get_cp().' '.$representant->get_ville()), 1, 1, 'C');
      $pdf->ln(-13);

      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(10, 35, c("Certifie renoncer au remboursement des frais ci-dessous et les laisser à l'association"), $border, 1, 'L');
      $pdf->SetFont ('Arial', '', 11);
      $trouver = false;
      $oldNom = array();
      $oldNom[0] = "";
      //$pdf->Cell(10, -13, c(""), $border, 1, 'L');//Justification d'espace
      $pdf->ln(-13);
      foreach ($representant->get_les_adherents() as $adherent){
        foreach ($oldNom as $nom ) {
          if($adherent->get_Club()->get_Nom() == $nom){
            $trouver = true;
          }
        }       
        if($trouver == false){

          $pdf->ln(0);
          $pdf->Cell(190, 7, c($adherent->get_Club()->get_Nom().' '.$adherent->get_Club()->get_AdresseClub().' '.$adherent->get_Club()->get_Cp().' '.$adherent->get_Club()->get_Ville()), 1, 1, 'C');
          $pdf->ln(0);

        }
        $oldNom[] = $adherent->get_Club()->get_Nom();
        $trouver = false;
      }

      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(21, 8, c("en tant que don."), $border, 1, 'L');
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Frais de deplacement"), $border, 0, 'L');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->Cell(215, 14, c("Tarif kilomètrique appliqué pour le remboursement :".$indemnite->get_tarifKilometrique()), $border, 1, 'C');
      $pdf->SetFont('Arial', '', 9);
      $header = array('Date', 'Motif', 'Trajet', 'Kilomètre','Cout trajet',c('Péages'),'Repas',c('Hébergement'),'Total');
      $lignes = $noteDeFrais->get_les_lignes();
      $totalT=$pdf->ImprovedTable($header, $lignes,$indemnite);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Je suis le représentant légal des adhérents suivants :"), $border, 0, 'L');
      $pdf->Ln();
      $pdf->SetFont ('Arial', '', 11);
      foreach ($representant->get_les_adherents() as $adherent){
        $pdf->ln(0);
      $pdf->Cell(190, 7, c($adherent->get_Nom().' '.$adherent->get_Prenom().' licence n° '.$adherent->get_numLicence()), 1, 1, 'C');
      $pdf->ln(0);
      }
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Montant total des dons : ".$totalT), $border,0, 'L');
      $pdf->SetFont ('Arial', 'I', 9);
      $pdf->Ln(7);
      $pdf->Cell(30, 14, c("Pour bénéficier du reçu de dons, cette note de frais doit être accompagnée de tous les justificatifs correspondants"), $border, 0, 'L');
      $pdf->Ln(7);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 17, c("A"), $border,0, 'L');
      $pdf->Cell(45, 17, c("Le"), $border,1, 'C');
      $pdf->Cell(30, 14, c("Signature du bénévole :"), $border,1, 'L');
      $pdf->ln(7);
      $width = 100;
      $height = 15;
      $pdf->setX(11);
      $y = $pdf->getY(50);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(74,8, c("Partie réservé à l'association"), $border,1, 'R');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->MultiCell($width,7, c("N° ordre de reçu : ".$noteDeFrais->get_les_lignes()[0]->get_Annee().' - '.$noteDeFrais->get_Id_NoteDeFrais()."\nRemis le :\nSignature du trésorier :\n\n\n"),1);
      $pdf->setY($y + $height);
    }
    else{
      $adherent = $demandeur->get_Adherent();
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(28, 35, c("Je sousigné(e)"), $border, 1, 'L');
      $pdf->SetFont ('Arial', '', 10);

      $pdf->ln(-13);
      $pdf->Cell(190, 7, c($adherent->get_Nom().' '.$adherent->get_Prenom()), 1, 1, 'C');
      $pdf->ln(-13);

      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(21, 35, c("Demeurant"), $border, 1, 'L');
      $pdf->SetFont ('Arial', '', 10);

      $pdf->ln(-13);
      $pdf->Cell(190, 7, c($adherent->get_AdresseAdh().' '.$adherent->get_cp().' '.$adherent->get_ville()), 1, 1, 'C');
      $pdf->ln(-13);

      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(160, 38, c("Certifie renoncer au remboursement des frais ci-dessous et les laisser à l'association"), $border, 1, 'L');
     // $pdf->Cell(10, -16, c(""), $border, 1, 'L');//Justification d'espace
      $pdf->SetFont ('Arial', '', 10);

      $pdf->ln(-13);
      $pdf->Cell(190, 7, c($adherent->get_Club()->get_Nom()), 1, 1, 'C');
      $pdf->ln(0);

      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(21, 8, c("en tant que don."), $border, 1, 'L');
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Frais de deplacement"), $border, 0, 'L');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->Cell(215, 14, c("Tarif kilomètrique appliqué pour le remboursement :".$indemnite->get_tarifKilometrique()), $border, 1, 'C');
      $pdf->SetFont('Arial', '', 9);
      $header = array('Date', 'Motif', 'Trajet', c('Kilomètre'),'Cout trajet',c('Péages'),'Repas',c('Hébergement'),'Total');
      $lignes = $noteDeFrais->get_les_lignes();
      $totalT = $pdf->ImprovedTable($header, $lignes,$indemnite);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(28, 14, c("Je suis licencié sous le n° de licence suivant :"), $border, 0, 'L');
      $pdf->SetFont ('Arial', '', 10);

      $pdf->ln();
      $pdf->Cell(190, 7, c($adherent->get_Nom().' '.$adherent->get_Prenom().' licence n° '.$adherent->get_numLicence()), 1, 1, 'C');
      $pdf->ln();

      $pdf->Ln();
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, -8, c("Montant total des dons : ".$totalT), $border,0, 'L');
      $pdf->SetFont ('Arial', 'I', 9);
      $pdf->Ln(7);
      $pdf->Cell(30, -9, c("Pour bénéficier du reçu de dons, cette note de frais doit être accompagnée de tous les justificatifs correspondants"), $border, 0, 'L');
      $pdf->Ln(7);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, -8, c("A"), $border,0, 'L');
      $pdf->Cell(30, -8, c("Le"), $border,1, 'R');
      $pdf->Cell(30, 25, c("Signature du bénévole :"), $border,1, 'L');
      $width = 100;
      $height = 15;
      $pdf->Ln(10);
      $pdf->setX(11);
      $y = $pdf->getY(50);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(74,8, c("Partie réservé à l'association"), $border,1, 'R');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->MultiCell($width,7, c("N° ordre de reçu : ".$noteDeFrais->get_les_lignes()[0]->get_Annee().' - '.$noteDeFrais->get_Id_NoteDeFrais()."\nRemis le :\nSignature du trésorier :\n\n\n"),1);
      $pdf->setY($y + $height);
    }
    
  $pdf->Output();
}
}
// Classe AdherentController
