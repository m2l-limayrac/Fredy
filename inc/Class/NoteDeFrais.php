<?php

class NoteDeFrais{

  private $Id_NoteDeFrais;
 

  function __construct(array $tableau) {
    $this->hydrater($tableau);
  }

  // Getter setter

  function get_Id_NoteDeFrais() {
    return $this->Id_NoteDeFrais;
  }

  function set_Id_NoteDeFrais($Id_NoteDeFrais) {
    $this->Id_NoteDeFrais = $Id_NoteDeFrais;
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
