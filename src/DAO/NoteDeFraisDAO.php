<?php

/**
 * Dao Demandeur 
 *
 * @author jef
 */
require_once SRC . DS . 'models' . DS . 'Demandeur.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'DAO' . DS . 'LigneFraisDAO.php';
require_once SRC . DS . 'models' . DS . 'NoteDeFrais.php';
require_once SRC . DS . 'models' . DS . 'Lignefrais.php';


class NoteDeFraisDAO extends DAO {

  private static $LigneFraisDAO;

  function find($Id_NoteDeFrais) {
    $sql = "SELECT * FROM notedefrais WHERE Id_NoteDeFrais=:Id_NoteDeFrais";
    try {
      $params = array(":Id_NoteDeFrais" => $Id_NoteDeFrais);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    $noteDeFrais = new NoteDeFrais($row);
    if(SELF::$LigneFraisDAO == null){
      SELF::$LigneFraisDAO = new LigneFraisDAO();
    }

    $noteDeFrais->set_les_lignes($this->findLigneDeFrais($noteDeFrais->get_Id_NoteDeFrais()));

    return $noteDeFrais; // Retourne l'objet métier
  }

  /**
   * Lecture de toutes les chaloupes
   */
  function findAll() {
    $sql = "SELECT * FROM notedefrais";
    try { 
      $sth = $this->executer($sql);
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    $objects = array();
    foreach ($rows as $row) {
      $object = New NoteDeFrais($row);
      $les_notes = $this->findNoteDeFrais($object->get_Id_Demandeur());
      $objects[] = $object;
    }

    return $objects;
  }
  
  function insert(){
    //GLOBAL $con;

    $sql = "INSERT INTO notedefrais () VALUES ()";
    try {
        $sth = $this->executer($sql);
        $return = SELF::$connexion->lastInsertId();
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
    return $return;
}

  function update(NoteDeFrais $noteDeFrais){
    //GLOBAL $con;
    
    $sql = "UPDATE notedefrais SET Id_noteDeFrais = :Id_noteDeFrais, isValidate = :isValidate WHERE Id_noteDeFrais = :Id_noteDeFrais";
      try {
          $params = array(':Id_noteDeFrais' => $noteDeFrais->get_Id_noteDeFrais(),
                          ':isValidate' => $noteDeFrais->get_isValidate());
          $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
  }

  function delete (NoteDeFrais $noteDeFrais){
    //GLOBAL $con;
    
    $sql = "DELETE FROM notedefrais WHERE Id_noteDeFrais = :Id_noteDeFrais";
      try {
        $params = array(':Id_noteDeFrais' => $noteDeFrais->get_Id_NoteDeFrais());
        $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }        
  }
  
  function findLigneDeFrais($Id_NoteDeFrais) {
    $sql = "SELECT lignefrais.* FROM lignefrais, avancer WHERE avancer.id_Ligne = lignefrais.id_Ligne AND avancer.Id_NoteDeFrais = :Id_NoteDeFrais";
    try {
      $params = array(":Id_NoteDeFrais" => $Id_NoteDeFrais);
      $sth = $this->executer($sql, $params);
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    
    $lignes = array();
    foreach ($rows as $row) {
      $lignefrais = new Lignefrais($row);
      $lignefrais->set_Motif($this->findMotif($lignefrais->get_Id_Ligne()));
      $lignes[] = $lignefrais;

    }    
    return $lignes; // Retourne l'objet métier
  }

  function findAnneeNoteFrais($Id_NoteDeFrais) {
    $sql = "SELECT DISTINCT lignefrais.Annee FROM lignefrais, avancer WHERE lignefrais.id_Ligne = avancer.id_Ligne AND avancer.Id_NoteDeFrais = :Id_NoteDeFrais";
    try {
      $params = array(":Id_NoteDeFrais" => $Id_NoteDeFrais);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    
   /* $noteDeFrais = new NoteDeFrais($row);
    if(SELF::$LigneFraisDAO == null){
      SELF::$LigneFraisDAO = new LigneFraisDAO();
    }

    $noteDeFrais->set_les_lignes($this->findLigneDeFrais($NoteDeFrais->get_Id_NoteDeFrais()));
    */
    return $row; // Retourne l'objet métier
  }

  function findMotif($id_Ligne) {
    $sql = "SELECT motif.Libelle FROM motif, lignefrais WHERE lignefrais.Id_Motif = motif.Id_Motif and lignefrais.id_Ligne = :id_Ligne";
    try {
      $params = array(":id_Ligne" => $id_Ligne);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    
   /* $noteDeFrais = new NoteDeFrais($row);
    if(SELF::$LigneFraisDAO == null){
      SELF::$LigneFraisDAO = new LigneFraisDAO();
    }

    $noteDeFrais->set_les_lignes($this->findLigneDeFrais($NoteDeFrais->get_Id_NoteDeFrais()));
    */
    foreach ($row as $key => $value) {
      $row = $value;
    }
    return $row; // Retourne l'objet métier
  }
}
