<?php

require_once 'inc/Class/Motif.php';
/**
 * Description of EtablissementDAO
 *
 * @author jef
 */

class MotifDAO {

  private static $connexion;    // Objet de connexion

  /**
   * Méthode statique de connexion
   * @return type
   * @throws Exception
   */

  private static function get_connexion() {
    if (self::$connexion === null) {
// Récupération des paramètres de configuration BD
      $user = 'root';
      $pass = '';
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

  /**
   * Lecture d'un établissement par son ID
   *
   * @param type $id_etablissement
   * @return \Etablissement
   * @throws Exception
   */
  function find($Id_Motif) {
    $sql = "select * from motif where Id_Motif=:Id_Motif";
    try {
      $sth = self::get_connexion()->prepare($sql);
      $sth->execute(array(":Id_Motif" => $id_etablissement));
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $motif = new motif($row);

    return $motif;
  }

  /**
   * Lecture de tous les établissements
   */
  function findAll() {
    $sql = "select * from motif";
    try {
      $sth = self::get_connexion()->prepare($sql);
      $sth->execute();
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $tableau = array();
    foreach ($rows as $row) {
      $tableau[] = new motif($row);
    }
    // Retourne un tableau d'objets
    return $tableau;
  }

}
