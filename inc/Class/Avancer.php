<?php
class Avancer {
    
    private $Id_Demandeur;
    private $Id_Ligne;    
    private $Id_NoteDeFrais;

    function __construct(array $tab = null) {  //constructeur
     if (!is_null($tab)) {
        $this->hydrater($tab);
     }
    }

    function get_Id_Demandeur() {
        return $this->Id_Demandeur;
    }

    function get_Id_Ligne() {
        return $this->Id_Ligne;
    }

    function get_Id_NoteDeFrais() {
        return $this->Id_NoteDeFrais;
    }

    function set_Id_Demandeur($Id_Demandeur) {
        $this->Id_Demandeur = $Id_Demandeur;
    }

    function set_Id_Ligne($Id_Ligne) {
        $this->Id_Ligne = $Id_Ligne;
    }

    function set_Id_NoteDeFrais($Id_NoteDeFrais) {
        $this->Id_NoteDeFrais = $Id_NoteDeFrais;
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