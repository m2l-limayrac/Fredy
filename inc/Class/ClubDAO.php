<?php

include_once 'inc/Class/Club.php';

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

  function find($Id_Club) {

    $sql = "SELECT * FROM club WHERE Id_Club = :Id_Club";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute(array(':Id_Club' => $Id_Club));
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $club = new Club($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $club;
  }

  function findAll() {

    $sql = "SELECT * FROM club;";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute();
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $object = array();
      foreach ($rows as $row) {
        $object = New Club($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

  function insert(Club $Club){
    $sql = "INSERT INTO `club`(`Id_Club`, `Nom`, `AdresseClub`, `Cp`, `Ville`, `Sigle`, `NomPresident`, `Id_Ligue`) 
    VALUES (:Id_Club,:Nom,:AdresseClub,:Cp,:Ville,:Sigle,:NomPresident,:Id_Ligue)";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(':Id_Club' => $Club->get_Id_Club(), 
                          ':Nom' => $Club->get_Nom(), 
                          ':AdresseClub' => $Club->get_AdresseClub(), 
                          ':Cp' => $Club->get_Cp(),
                          ':Ville' => $Club->get_Ville(),
                          ':Sigle' => $Club->get_Sigle(),
                          ':NomPresident' => $Club->get_NomPresident(),
                          ':Id_Ligue' => $Club->get_id_Ligue()
                          ));
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }

  function update(Club $Club) {
    $sql = "UPDATE club set Nom=:Nom,AdresseClub=:AdresseClub,Cp=:Cp,Ville=:Ville,Sigle=:Sigle,NomPresident=:NomPresident,Id_Ligue=:Id_Ligue where Id_Club=:Id_Club";
    try {
      $sth = SELF::$con->prepare($sql);
       $sth->execute(array(':Id_Club' => $Club->get_Id_Club(), 
                          ':Nom' => $Club->get_Nom(), 
                          ':AdresseClub' => $Club->get_AdresseClub(), 
                          ':Cp' => $Club->get_Cp(),
                          ':Ville' => $Club->get_Ville(),
                          ':Sigle' => $Club->get_Sigle(),
                          ':NomPresident' => $Club->get_NomPresident(),
                          ':Id_Ligue' => $Club->get_id_Ligue()
                          ));
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $nb = $sth->rowcount();
    return $nb;  // Retourne le nombre de mise à jour
  }

  function delete(Club $Club) {
    print_r($Club);
    $sql = "DELETE from Club where Id_Club = :Id_Club ";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(":Id_Club" => $Club->get_Id_Club()));
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
  }
}

?>