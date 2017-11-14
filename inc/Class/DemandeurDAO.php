<?php

/**
 * Dao Demandeur 
 *
 * @author jef
 */
include_once 'inc/Class/NoteDeFraisDAO.php';
include_once 'inc/Class/NoteDeFrais.php';
include_once 'inc/Class/Demandeur.php';

class DemandeurDAO {

  private static $con; // Objet de connexion
  private static $NoteDeFraisDAO;
  
  function __construct() {
    SELF::$con = $this->connexion();
  }


  private static function connexion() {
    if (SELF::$con === null) {
      // Récupération des paramètres de configuration BD
      $user = 'TEST';
      $pass = '1234';
      $host = 'localhost';
      $base = 'fredi_plot3';
      $dsn = 'mysql:host=' . $host . ';dbname=' . $base;
      // Création de la connexion
      try {
        SELF::$con = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        SELF::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        throw new Exception("Erreur lors de la con : " . $e->getMessage());
      }
    }
    return SELF::$con;
  }

  function find($Id_Demandeur) {
    $sql = "SELECT * FROM demandeur WHERE Id_Demandeur=:Id_Demandeur";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(":Id_Demandeur" => $Id_Demandeur));
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

  /**
   * Lecture de toutes les chaloupes
   */
  function findAll() {
    $sql = "SELECT * FROM demandeur";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute();
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
              $sth = SELF::$con->prepare($sql);
              $sth->execute(array(':AdresseMail' => $demandeur->get_AdresseMail(), 
                                  ':MotDePasse' => $demandeur->get_MotDePasse()
                                  ));
          } catch (PDOException $ex) {
              die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
          }
  }

  function update(Demandeur $demandeur){
    //GLOBAL $con;
    
    $sql = "UPDATE demandeur SET Id_Demandeur = :Id_Demandeur, AdresseMail = :AdresseMail, MotDePasse = :MotDePasse WHERE Id_Demandeur = :Id_Demandeur";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute(array(':Id_Demandeur' => $demandeur->get_Id_Demandeur(), 
                              ':AdresseMail' => $demandeur->get_AdresseMail(), 
                              ':MotDePasse' => $demandeur->get_MotDePasse()
                              ));
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
  }

  function delete (Demandeur $demandeur){
    //GLOBAL $con;
    
    $sql = "DELETE FROM demandeur WHERE Id_Demandeur = :Id_Demandeur";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute(array(':Id_Demandeur' => $demandeur->get_Id_Demandeur()));
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }        
  }
  
  function findNoteDeFrais($Id_Demandeur) {
    $sql = "SELECT Id_NoteDeFrais FROM avancer WHERE Id_Demandeur = :Id_Demandeur";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(":Id_Demandeur" => $Id_Demandeur));
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
