<?php

/**
 * Dao Demandeur 
 *
 * @author jef
 */
require_once SRC . DS . 'models' . DS . 'Demandeur.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'DAO' . DS . 'NoteDeFraisDAO.php';

class DemandeurDAO extends DAO {

  private static $NoteDeFraisDAO;

  function find($Id_Demandeur) {
    $sql = "SELECT * FROM demandeur WHERE Id_Demandeur=:Id_Demandeur";
    try {
      $params = array(":Id_Demandeur" => $Id_Demandeur);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    
    $demandeur = new Demandeur($row);
    if(SELF::$NoteDeFraisDAO == null){
      SELF::$NoteDeFraisDAO = new NoteDeFraisDAO();
    }

    $demandeur->set_les_notes($this->findNoteDeFrais($demandeur));
    
    return $demandeur; // Retourne l'objet métier
  }

  function findAllByMail($AdresseMail) {
    $sql = "SELECT * FROM demandeur WHERE AdresseMail=:AdresseMail";
    try {
      $params = array(":AdresseMail" => $AdresseMail);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    if($row != false){
      $demandeur = new Demandeur($row);
      /*if(SELF::$NoteDeFraisDAO == null){
        SELF::$NoteDeFraisDAO = new NoteDeFraisDAO();
      }*/

      //$demandeur->set_les_notes($this->findNoteDeFrais($demandeur));      
    }else{
      $row = array();
    }
    
    return $demandeur; // Retourne l'objet métier
  }

  /**
   * Lecture de toutes les chaloupes
   */
  function findAll() {
    $sql = "SELECT * FROM demandeur";
    try { 
      $sth = $this->executer($sql);
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    $objects = array();
    foreach ($rows as $row) {
      $object = New Demandeur($row);
      $les_notes = $this->findNoteDeFrais($object->get_Id_Demandeur());
      $objects[] = $object;
    }

    return $objects;
  }
  
  function insert(Demandeur $demandeur){
    //GLOBAL $con;

    $sql = "INSERT INTO demandeur (AdresseMail, MotDePasse) VALUES (:AdresseMail, :MotDePasse)";
    try {
        $params = array(':AdresseMail' => $demandeur->get_AdresseMail(), 
                        ':MotDePasse' => $demandeur->get_MotDePasse());
        $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
}

  function update(Demandeur $demandeur){
    //GLOBAL $con;
    
    $sql = "UPDATE demandeur SET Id_Demandeur = :Id_Demandeur, AdresseMail = :AdresseMail, MotDePasse = :MotDePasse WHERE Id_Demandeur = :Id_Demandeur";
      try {
          $params = array(':Id_Demandeur' => $demandeur->get_Id_Demandeur(), 
                              ':AdresseMail' => $demandeur->get_AdresseMail(), 
                              ':MotDePasse' => $demandeur->get_MotDePasse());
          $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
  }

  function delete (Demandeur $demandeur){
    //GLOBAL $con;
    
    $sql = "DELETE FROM demandeur WHERE Id_Demandeur = :Id_Demandeur";
      try {
        $params = array(':Id_Demandeur' => $demandeur->get_Id_Demandeur());
        $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }        
  }
  
  function findNoteDeFrais($Id_Demandeur) {
    $sql = "SELECT Id_NoteDeFrais FROM avancer WHERE Id_Demandeur = :Id_Demandeur";
    try {
      $params = array(":Id_Demandeur" => $Id_Demandeur);
      $sth = $this->executer($sql, $params);
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    
    $notes = array();
    foreach ($rows as $row) {
      $NoteDeFrais = new NoteDeFrais($row);
      $notes[] = $NoteDeFrais;
    }    
    return $demandeur; // Retourne l'objet métier
  }

}
