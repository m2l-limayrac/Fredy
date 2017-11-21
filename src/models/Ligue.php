<?php

class Ligue{

  private $Id_Ligue;
  private $Nom_ligue;  // A,B,C,....

 

  function __construct(array $tableau) {
    $this->hydrater($tableau);
  }

  // Getter setter

  function get_Id_Ligue() {
    return $this->Id_Ligue;
  }

  function get_Nom_ligue() {
    return $this->Nom_ligue;
  }

  function set_Id_Ligue($Id_Ligue) {
    $this->Id_Ligue = $Id_Ligue;
  }

  function set_Nom_ligue($Nom_ligue) {
    $this->Nom_ligue = $Nom_ligue;
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
