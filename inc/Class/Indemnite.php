<?php

/**
 * 
 *
 * @author jef
 */
class Demandeur {

  private $Annee;                       // annee 
  private $tarifKilometrique;           // le tarif kilometrique

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

  function get_Annee() {
    return $this->Annee;
  }

  function get_tarifKilometrique() {
    return $this->AdresseMail;
  }

  // Setter

  function set_Annee($Annee) {
    $this->Annee = $Annee;
  }

  function set_tarifKilometrique($tarifKilometrique) {
    $this->tarifKilometrique = $tarifKilometrique;
  }

  
}
