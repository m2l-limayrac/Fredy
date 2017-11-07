<?php
class Adherent {
    private $numLicence;
    private $Nom;
    private $Prenom;
    private $Sexe;
    private $DateNaissance;
    private $AdresseAdh;
    private $Cp;
    private $Ville;
    private $Id_Demandeur;
    private $Id_Club;

    function __construct(array $tab = null) {  //constructeur
     if (!is_null($tab)) {
        $this->hydrater($tab);
     }
    }

    function get_numLicence() {
        return $this->numLicence;
    }

    function get_Nom() {
        return $this->Nom;
    }

    function get_Prenom() {
        return $this->Prenom;
    }

    function get_Sexe() {
        return $this->Sexe;
    }

    function get_DateNaissance() {
        return $this->DateNaissance;
    }

    function get_AdresseAdh() {
        return $this->AdresseAdh;
    }

    function get_Cp() {
        return $this->Cp;
    }

    function get_Ville() {
        return $this->Ville;
    }

    function get_Id_Demandeur() {
        return $this->Id_Demandeur;
    }

    function get_Id_Club() {
        return $this->Id_Club;
    }

    function set_numLicence($numLicence) {
        $this->numLicence = $numLicence;
    }

    function set_Nom($Nom) {
        $this->Nom = $Nom;
    }

    function set_Prenom($Prenom) {
        $this->Prenom = $Prenom;
    }

    function set_Sexe($Sexe) {
        $this->Sexe = $Sexe;
    }

    function set_DateNaissance($DateNaissance) {
        $this->DateNaissance = $DateNaissance;
    }

    function set_AdresseAdh($AdresseAdh) {
        $this->AdresseAdh = $AdresseAdh;
    }

    function set_Cp($Cp) {
        $this->Cp = $Cp;
    }

    function set_Ville($Ville) {
        $this->Ville = $Ville;
    }

    function set_Id_Demandeur($Id_Demandeur) {
        $this->Id_Demandeur = $Id_Demandeur;
    }

    function set_Id_Club($Id_Club) {
        $this->Id_Club = $Id_Club;
    }

    function hydrater(array $tableau) { //appel les setter de toutes les methodes passer dans un tableau.
    foreach ($tableau as $cle => $valeur) {
      $methode = 'set_' . $cle;
      if (method_exists($this, $methode)) {
        $this->$methode($valeur);
      }
    }
  }
}
?>