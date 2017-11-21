<?php


class ligneFrais {



  private $Id_Ligne;        // id de la ligne de frais  
  private $Date;           // date
  private $Km;        // nb de kilimetre 
  private $CoutPeage;        // le cout du peage  
  private $CoutRepas;        // le cout du repas 
  private $CoutHebergement;        // le cout de l'hebergement 
  private $Trajet;        // trajet   
  private $Annee;        // annee 
  private $Id_Motif;        // l'id du motif  

  /**
   * Constructeur
   * @param type $nom
   */

  function __construct(array $tableau = null) {
    if (isset($tableau)) {
      $this->hydrater($tableau);
    }
  }

  // Getter

  function get_Id_Ligne() {
    return $this->Id_Ligne;
  }

  function get_Date() {
    return $this->Date;
  }

  function get_Km() {
    return $this->Km;
  }
  function get_CoutPeage() {
    return $this->CoutPeage;
  }
  function get_CoutRepas() {
    return $this->CoutRepas;
  }
  function get_CoutHebergement() {
    return $this->CoutHebergement;
  }
  function get_Trajet() {
    return $this->Trajet;
  }
  function get_Annee() {
    return $this->Annee;
  }
  function get_Id_Motif() {
    return $this->Id_Motif;
  }

  // Setter

  function set_Id_Ligne($Id_Ligne) {
    $this->Id_Ligne = $Id_Ligne;
  }
  function set_Date($Date) {
    $this->Date = $Date;
  }
  function set_Km($Km) {
    $this->Km = $Km;
  }
  function set_CoutPeage($CoutPeage) {
    $this->CoutPeage = $CoutPeage;
  }
  function set_CoutRepas($CoutRepas) {
    $this->CoutRepas = $CoutRepas;
  }
  function set_CoutHebergement($CoutHebergement) {
    $this->CoutHebergement = $CoutHebergement;
  }
  function set_Trajet($Trajet) {
    $this->Trajet = $Trajet;
  }
  function set_Annee($Annee) {
    $this->Annee = $Annee;
  }
  function set_Id_Motif($Id_Motif) {
    $this->Id_Motif = $Id_Motif;
  }

  function hydrater(array $tableau) {
    foreach ($tableau as $cle => $valeur) {
      $methode = 'set_' . $cle;
      if (method_exists($this, $methode)) {
        $this->$methode($valeur);
      }
    }
  }
  
}
