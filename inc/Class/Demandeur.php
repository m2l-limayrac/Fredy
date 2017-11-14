<?php

class Demandeur {

  private $Id_Demandeur;     // id du demandeur
  private $AdresseMail;           // addresse mail 
  private $MotDePasse;     // mot de passe 
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

function hydrater(array $tableau) { //appel les setter de toutes les methodes passer dans un tableau.
    foreach ($tableau as $cle => $valeur) {
      $methode = 'set_' . $cle;
      if (method_exists($this, $methode)) {
        $this->$methode($valeur);
      }
    }
  }


}
