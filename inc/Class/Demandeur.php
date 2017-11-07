<?php

/**
 * 
 *
 * @author jef
 */
class Demandeur {

  private $Id_Demandeur;     // id du demandeur
  private $AdresseMail;           // addresse mail 
  private $MotDePasse;     // mot de passe 

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

  function get_Id_Demandeur() {
    return $this->Id_Demandeur;
  }

  function get_AdresseMail() {
    return $this->AdresseMail;
  }

  function get_MotDePasse() {
    return $this->MotDePasse;
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


}
