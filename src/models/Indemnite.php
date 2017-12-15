<?php

/**
 * 
 *
 * @author jef
 */
class Indemnite {

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
    return $this->tarifKilometrique;
  }

  // Setter

  function set_Annee($Annee) {
    $this->Annee = $Annee;
  }

  function set_tarifKilometrique($tarifKilometrique) {
    $this->tarifKilometrique = $tarifKilometrique;
  }

    /**
   * Hydrateur
   * Alimente les propriétés à partir d'un tableau
   * @param array $tableau
   */
  function hydrater(array $tableau) {
    foreach ($tableau as $cle => $valeur) {
      $methode = 'set_' . $cle;
      if (method_exists($this, $methode)) {
        $this->$methode($valeur);
      }
    }
  }
  
}
