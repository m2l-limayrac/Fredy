<?php

class Demandeur {

  private $Id_Demandeur;     // id du demandeur
  private $AdresseMail;           // addresse mail 
  private $MotDePasse;     // mot de passe 
  private $isRepresentant;     // mot de passe 

  private $Representant;
  private $Adherent;

  private $les_notes = array();


  function __construct(array $tableau = null) {
    if (isset($tableau)) {
      $this->hydrater($tableau);
    }
  }

  // Getter

  function get_Id_Demandeur() {
    return $this->Id_Demandeur;
  }

  function get_AdresseMail() {
    return $this->AdresseMail;
  }

  function get_MotDePasse() {
    return $this->MotDePasse;
  }

  function get_les_notes() {
    return $this->les_notes;
  }

  function get_isRepresentant() {
    return $this->isRepresentant;
  }

  function get_int_isRepresentant() {
    if($this->isRepresentant){
      return 1;
    }else{
      return 0;
    }
  }

  function get_Representant() {
    return $this->Representant;
  }

  function get_Adherent() {
    return $this->Adherent;
  }

  // Setter

  function set_Id_Demandeur($Id_Demandeur) {
    $this->Id_Demandeur = $Id_Demandeur;
  }

  function set_AdresseMail($AdresseMail) {
    $this->AdresseMail = $AdresseMail;
  }

  function set_MotDePasse($MotDePasse) {
    $this->MotDePasse = $MotDePasse;
  }

  function set_les_notes($les_notes) {
    $this->les_notes = $les_notes;
  }

  function set_Representant($Representant) {
    $this->Representant = $Representant;
  }

  function set_Adherent($Adherent) {
    $this->Adherent = $Adherent;
  }

  function set_isRepresentant($isRepresentant) {
    if($isRepresentant == 1){
      $this->isRepresentant = true;
    }else{
      $this->isRepresentant = false;
    }
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
