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
require_once SRC . DS . 'DAO' . DS . 'DemandeurDAO.php';
require_once SRC . DS . 'models' . DS . 'Adherent.php';
require_once SRC . DS . 'models' . DS . 'LigneFrais.php';
require_once SRC . DS . 'DAO' . DS . 'AdherentDAO.php';
require_once SRC . DS . 'DAO' . DS . 'LigueDAO.php';
require_once SRC . DS . 'DAO' . DS . 'LigneFraisDAO.php';
require_once SRC . DS . 'DAO' . DS . 'MotifDAO.php';
require_once SRC . DS . 'DAO' . DS . 'IndemniteDAO.php';
require_once SRC . DS . 'DAO' . DS . 'ClubDAO.php';
require_once SRC . DS . 'models' . DS . 'MyFPDF.php';



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

  /**
   * Détails d'un utilisateur
   */
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
      $demandeur = new Demandeur(array(
          'AdresseMail' => $this->request->get('AdresseMail'),
          'MotDePasse' => $this->request->get('MotDePasse'),
          'isRepresentant' => $this->request->get('isRepresentant')
      ));
      if (Auth::inscrire($demandeur)) {


        //INSCRIRE LE REPRESENTANT ET L'ADHERENT EN FONCTION DE ISREPRESENTANT







        Flash::add("Vous êtes inscrit !", 1);
        $this->redirect('adherent/ajout');
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
      $pdf->Cell(36, -23, c($representant->get_Nom().' '.$representant->get_Prenom()), $border, 1, 'L');
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(21, 35, c("Demeurant"), $border, 1, 'L');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->Cell(29, -23, c($representant->get_rue().' '.$representant->get_cp().' '.$representant->get_ville()), $border, 1, 'L');
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(10, 35, c("Certifie renoncer au remboursement des frais ci-dessous et les laisser a l'association"), $border, 1, 'L');
      $pdf->SetFont ('Arial', '', 11);
      $trouver = false;
      $oldNom = array();
      $oldNom[0] = "";
      $pdf->Cell(10, -13, c(""), $border, 1, 'L');//Justification d'espace
      foreach ($representant->get_les_adherents() as $adherent){
        foreach ($oldNom as $nom ) {
          if($adherent->get_Club()->get_Nom() == $nom){
            $trouver = true;
          }
        }       
        if($trouver == false){
          $pdf->Cell(60, 8, c($adherent->get_Club()->get_Nom().' '.$adherent->get_Club()->get_AdresseClub().' '.$adherent->get_Club()->get_Cp().' '.$adherent->get_Club()->get_Ville()), $border, 1, 'L');
        }
        $oldNom[] = $adherent->get_Club()->get_Nom();
        $trouver = false;
      }
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(21, 8, c("en tant que don."), $border, 1, 'L');
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Frais de deplacement"), $border, 0, 'L');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->Cell(215, 14, c("Tarif kilometrique appliqué pour le remboursement :".$indemnite->get_tarifKilometrique()), $border, 1, 'C');
      $pdf->SetFont('Arial', '', 9);
      $header = array('Date', 'Motif', 'Trajet', 'Kilometre','Cout trajet','Péages','Repas','Hébergement','Total');
      $lignes = $noteDeFrais->get_les_lignes();
      $pdf->ImprovedTable($header, $lignes,$indemnite);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Je suis le représentant légale des adhérents suivants :"), $border, 0, 'L');
      $pdf->Ln();
      $pdf->SetFont ('Arial', '', 11);
      foreach ($representant->get_les_adherents() as $adherent){
          $pdf->Cell(30, 8, c($adherent->get_Nom().' licence numéro '.$adherent->get_numLicence()), $border, 0, 'L');
          $pdf->Ln(7);
      }
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Montant total des dons :"), $border,0, 'L');
      $pdf->SetFont ('Arial', 'I', 9);
      $pdf->Ln(7);
      $pdf->Cell(30, 14, c("Pour bénéficier du reçu de dons, cette note de frais doit être accompagnée de toutes les justificatifs correspondants"), $border, 0, 'L');
      $pdf->Ln(7);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("A"), $border,0, 'L');
      $pdf->Cell(30, 14, c("Le"), $border,1, 'L');
      $pdf->Cell(30, 14, c("Signature du bénevole :"), $border,1, 'L');
      $width = 100;
      $height = 15;
      $pdf->Ln(10);
      $pdf->setX(11);
      $y = $pdf->getY(50);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(74,8, c("Partie reservé à l'association"), $border,1, 'R');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->MultiCell($width,7, c("N° ordre de recu :\nRemis le :\nSignature du tresorier :"),1);
      $pdf->setY($y + $height);
    }
    else{
      $adherent = $demandeur->get_Adherent();

      $pdf->Cell(28, 35, c("Je sousigné(e)"), $border, 1, 'L');
      $pdf->Cell(20, -23, c($adherent->get_Nom().' '.$adherent->get_Prenom()), $border, 1, 'L');
      $pdf->Cell(21, 35, c("Demeurant"), $border, 1, 'L');
      $pdf->Cell(68, -23, c($adherent->get_AdresseAdh().' '.$adherent->get_cp().' '.$adherent->get_ville()), $border, 1, 'L');
      $pdf->Cell(160, 38, c("Certifie renoncer au remboursement des frais ci-dessous et les laisser a l'association"), $border, 1, 'L');
      $pdf->Cell(10, -16, c(""), $border, 1, 'L');//Justification d'espace
      $pdf->Cell(15, 8, c($adherent->get_Club()->get_Nom()), $border, 1, 'L');
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(21, 8, c("en tant que don."), $border, 1, 'L');
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Frais de deplacement"), $border, 0, 'L');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->Cell(215, 14, c("Tarif kilometrique appliqué pour le remboursement :".$indemnite->get_tarifKilometrique()), $border, 1, 'C');
      $pdf->SetFont('Arial', '', 9);
      $header = array('Date', 'Motif', 'Trajet', 'Kilometre','Cout trajet','Péages','Repas','Hébergement','Total');
      $lignes = $noteDeFrais->get_les_lignes();
      $pdf->ImprovedTable($header, $lignes,$indemnite);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Je sui licencié sous le n° de licence suivant :"), $border, 0, 'L');
      $pdf->Cell(32, 25, c($adherent->get_Nom().' '.$adherent->get_Prenom().' licence n° '.$adherent->get_numLicence()), $border, 0, 'R');
      $pdf->Ln();
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("Montant total des dons :"), $border,0, 'L');
      $pdf->SetFont ('Arial', 'I', 9);
      $pdf->Ln(7);
      $pdf->Cell(30, 14, c("Pour bénéficier du reçu de dons, cette note de frais doit être accompagnée de toutes les justificatifs correspondants"), $border, 0, 'L');
      $pdf->Ln(7);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(30, 14, c("A"), $border,0, 'L');
      $pdf->Cell(30, 14, c("Le"), $border,1, 'L');
      $pdf->Cell(30, 14, c("Signature du bénevole :"), $border,1, 'L');
      $width = 100;
      $height = 15;
      $pdf->Ln(10);
      $pdf->setX(11);
      $y = $pdf->getY(50);
      $pdf->SetFont ('Arial', 'B', 11);
      $pdf->Cell(74,8, c("Partie reservé à l'association"), $border,1, 'R');
      $pdf->SetFont ('Arial', '', 11);
      $pdf->MultiCell($width,7, c("N° ordre de recu :\nRemis le :\nSignature du tresorier :"),1);
      $pdf->setY($y + $height);
    }
    
  $pdf->Output();//probleme a resoudre
    
    // Génération du document PDF et envoi au navigateur

    //$pdf->Output('D', $filename);//probleme a resoudre
    //$this->redirect('demandeur/details');
  }


}

// Classe AdherentController
