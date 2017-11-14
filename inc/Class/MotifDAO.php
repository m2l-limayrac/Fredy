<?php

require_once 'inc/Class/Motif.php';


class MotifDAO {

  private static $con;    // Objet de connexion

  /**
   * Méthode statique de connexion
   * @return type
   * @throws Exception
   */

  function __construct() {
    SELF::$con = $this->connexion();
  }

private static function connexion(){
  // Connexion
  if(SELF::$con === null){
    $user = 'TEST';
    $pass = '1234';
    $host = 'localhost';
    $base = 'fredi_plot3';
    $dsn = 'mysql:host='.$host.';dbname='.$base;
    try {
      SELF::$con = new PDO($dsn, $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      SELF::$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die( "<p>Erreur lors de la connexion : " . $e->getMessage() . "</p>");
    }
  }
  return SELF::$con;
}


  function find($Id_Motif) {

    $sql = "SELECT * FROM motif WHERE Id_Motif = :Id_Motif";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute(array(':Id_Motif' => $Id_Motif));
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $motif = new Motif($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $motif;
  }

  function findAll() {

    $sql = "SELECT * FROM motif;";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute();
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $object = array();
      foreach ($rows as $row) {
        $object = New Motif($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

  function insert(Motif $Motif){
    $sql = "INSERT INTO `motif`(`Id_Motif`, `Libelle`) VALUES (:Id_Motif,:Libelle)";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(':Id_Motif' => $Motif->get_Id_Motif(), 
                          ':Libelle' => $Motif->get_Libelle(), 
                          ));
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }

  function update(Motif $Motif){
    //$sql = "UPDATE motif set Id_Motif=:Id_Motif , Libelle=:Libelle";
    $sql = "SHOW CREATE TABLE motif";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(':Id_Motif' => $Motif->get_Id_Motif(), 
                          ':Libelle' => $Motif->get_Libelle(), 
                          ));
       $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
    echo "<pre>"; print_r($row); echo "</pre>";
  }

  function delete(Motif $Motif){
    $sql = "DELETE FROM `motif` WHERE `Id_Motif` = :Id_Motif";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(':Id_Motif' => $Motif->get_Id_Motif(),  
                          ));
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }


}
