<?php
class Representant {
    
    private $Nom;    
    private $Prenom;
    private $Rue;
    private $Cp;
    private $Ville;
    private $id_Demandeur;

    function __construct(array $tab = null) {  //constructeur
     if (!is_null($tab)) {
        $this->hydrater($tab);
     }
    }

    function get_Nom() {
        return $this->Nom;
    }

    function get_Prenom() {
        return $this->Prenom;
    }

    function get_Rue() {
        return $this->Rue;
    }

    function get_Cp() {
        return $this->Cp;
    }

    function get_Ville() {
        return $this->Ville;
    }

    function get_id_Demandeur() {
        return $this->id_Demandeur;
    }

    function set_Nom($Nom) {
        $this->Nom = $Nom;
    }

    function set_Prenom($Prenom) {
        $this->Prenom = $Prenom;
    }

    function set_Rue($Rue) {
        $this->Rue = $Rue;
    }

    function set_Cp($Cp) {
        $this->Cp = $Cp;
    }

    function set_Ville($Ville) {
        $this->Ville = $Ville;
    }

    function set_id_Demandeur($id_Demandeur) {
        $this->id_Demandeur = $id_Demandeur;
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