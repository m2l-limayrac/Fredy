<?php

class Motif{

  private $Id_Motif;
  private $Libelle;  

 

  function __construct(array $tableau) {
    $this->hydrater($tableau);
  }

  // Getter setter

  function get_Id_Motif() {
    return $this->Id_Motif;
  }

  function get_Libelle() {
    return $this->Libelle;
  }

  function set_Id_Motif($Id_Motif) {
    $this->Id_Motif = $Id_Motif;
  }

  function set_Libelle($Libelle) {
    $this->Libelle = $Libelle;
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
