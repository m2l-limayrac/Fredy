<?php

include_once 'inc/Class/Ligue.php';

class ClubDAO {

  private static $con;

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

  function find($Id_Ligue) {

    $sql = "SELECT * FROM ligue WHERE Id_Ligue = :Id_Ligue";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute(array(':Id_Ligue' => $Id_Ligue));
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $ligue = new Ligue($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $ligue;
  }

  function findAll() {

    $sql = "SELECT * FROM ligue;";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute();
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $object = array();
      foreach ($rows as $row) {
        $object = New Ligue($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }
}

?>