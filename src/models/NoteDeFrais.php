<?php

class NoteDeFrais{

  private $Id_NoteDeFrais;
  private $isValidate = 0;
  private $les_lignes = array();
 

  function __construct(array $tableau = null) {
    if (isset($tableau)) {
      $this->hydrater($tableau);
    }
  }

  // Getter setter

  function get_Id_NoteDeFrais() {
    return $this->Id_NoteDeFrais;
  }

  function get_isValidate() {
    return $this->isValidate;
  }

  function get_boolIsValidate() {
    if($this->isValidate == 1){
      return true;
    }else{
      return false;
    }
  }

  function get_les_lignes() {
    return $this->les_lignes;
  }

  function set_Id_NoteDeFrais($Id_NoteDeFrais) {
    $this->Id_NoteDeFrais = $Id_NoteDeFrais;
  }

  function set_isValidate($isValidate) {
    if($isValidate == 1){
      $this->isValidate = true;
    }else{
      $this->isValidate = false;
    }
  }

  function set_les_lignes($les_lignes) {
    $this->les_lignes = $les_lignes;
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
