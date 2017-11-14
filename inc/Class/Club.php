<?php
class Club {
    
    private $Id_Club;
    private $Nom;    
    private $AdresseClub;
    private $Cp;
    private $Ville;
    private $Sigle;
    private $NomPresident;
    private $id_Ligue;
    
    function __construct(array $tab = null) {  //constructeur
     if (!is_null($tab)) {
        $this->hydrater($tab);
     }
    }

    function get_Id_Club() {
        return $this->Id_Club;
    }

    function get_AdresseClub() {
        return $this->AdresseClub;
    }

    function get_Nom() {
        return $this->Nom;
    }

    function get_Cp() {
        return $this->Cp;
    }

    function get_Ville() {
        return $this->Ville;
    }

    function get_Sigle() {
        return $this->Sigle;
    }

    function get_NomPresident() {
        return $this->NomPresident;
    }

    function get_id_Ligue() {
        return $this->id_Ligue;
    }

    function set_AdresseClub($AdresseClub) {
        $this->AdresseClub = $AdresseClub;
    }

    function set_Id_Club($Id_Club) {
        $this->Id_Club = $Id_Club;
    }

    function set_Nom($Nom) {
        $this->Nom = $Nom;
    }

    function set_Cp($Cp) {
        $this->Cp = $Cp;
    }

    function set_Ville($Ville) {
        $this->Ville = $Ville;
    }

    function set_Sigle($Sigle) {
        $this->Sigle = $Sigle;
    }

    function set_NomPresident($NomPresident) {
        $this->NomPresident = $NomPresident;
    }

    function set_id_Ligue($id_Ligue) {
        $this->id_Ligue = $id_Ligue;
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