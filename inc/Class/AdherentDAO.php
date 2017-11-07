<?php

include_once 'inc/Class/Adherent.php';

class AdherentDAO {

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

  function find($numLicence) {

    $sql = "SELECT * FROM adherent WHERE numLicence = :numLicence";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute(array(':numLicence' => $numLicence));
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $adherent = new Adherent($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $adherent;
  }

  function findAll() {

    $sql = "SELECT * FROM adherent;";
      try {
          $sth = SELF::$con->prepare($sql);
          $sth->execute();
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $object = array();
      foreach ($rows as $row) {
        $object = New Adherent($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

  function insert(Adherent $Adherent){
    $sql = "INSERT INTO `adherent`(`numLicence`, `Nom`, `Prenom`, `Sexe`, `DateNaissance`, `AdresseAdh`, `CP`, `Ville`, `Id_Demandeur`, `Id_Club`) VALUES (:numLicence,:Nom,:Prenom,:Sexe,:DateNaissance,:AdresseAdh,:CP,:Ville,:Id_Demandeur,:Id_Club)";
    try {
      $sth = SELF::$con->prepare($sql);
      $sth->execute(array(':numLicence' => $Adherent->get_numLicence(), 
                          ':Nom' => $Adherent->get_Nom(), 
                          ':Prenom' => $Adherent->get_Prenom(), 
                          ':Sexe' => $Adherent->get_Sexe(),
                          'DateNaissance' => $Adherent->get_DateNaissance(),
                          ':AdresseAdh' => $Adherent->get_AdresseAdh(),
                          ':CP' => $Adherent->get_CP(),
                          ':Ville' => $Adherent->get_Ville(),
                          ':Id_Demandeur' => $Adherent->get_Id_Demandeur(),
                          ':Id_Club' => $Adherent->get_Id_Club()
                          ));
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }
}

?>