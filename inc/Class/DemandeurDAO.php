<?php

/**
 * Dao Demandeur 
 *
 * @author jef
 */
include_once 'inc/Class/NoteDeFraisDAO.php'
include_once 'inc/Class/Demandeur.php';

class DemandeurDAO {

  private static $connexion; // Objet de connexion
  private static $NoteDeFraisDAO;
  /**
   * Méthode statique de connexion
   * @return type
   * @throws Exception
   */

  private static function get_connexion() {
    if (self::$connexion === null) {
      // Récupération des paramètres de configuration BD
      $user = 'TEST';
      $pass = '1234';
      $host = 'localhost';
      $base = 'fredi_plot3';
      $dsn = 'mysql:host=' . $host . ';dbname=' . $base;
      // Création de la connexion
      try {
        self::$connexion = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        throw new Exception("Erreur lors de la connexion : " . $e->getMessage());
      }
    }
    return self::$connexion;
  }

  function find($Id_Demandeur) {
    $sql = "select * from demandeur where Id_Demandeur=:Id_Demandeur";
    try {
      $sth = self::get_connexion()->prepare($sql);
      $sth->execute(array(":Id_Demandeur" => $Id_Demandeur));
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    
    $demandeur = new Demandeur($row);
    if(SELF::$NoteDeFraisDAO == null){
      SELF::$NoteDeFraisDAO = new NoteDeFraisDAO();
    }

    $demandeur->set_les_notes($NoteDeFraisDAO->find($demandeur->get_Id_Demandeur()));
    
    return $demandeur; // Retourne l'objet métier
  }

  /**
   * Lecture de toutes les chaloupes
   */
  function findAll() {
    $sql = "select * from demandeur";
    try {
      $sth = self::get_connexion()->prepare($sql);
      $sth->execute();
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $tableau = array();
    $demandeur = new DemandeurDAO($row);
    foreach ($rows as $row) {
      $NoteDeFraisDAO = new NoteDeFraisDAO($row);
      $Demandeur = $demandeur->find($row["Id_Demandeur"]);
      $demandeur->set_Id_Demandeur($Demandeur);
      $tableau[] = $demandeur;
    }
    return $tableau; // Retourne un tableau d'objets
  }
  
  
  
}
