<?php

/**
 * Classe mère DAO
 *
 * @author jef
 */
include SRC . DS . "framework" . DS . "Config.php";

abstract class DAO {

  private static $connexion;    // Objet de connexion

  /**
   * Ouvre une connexion (en, late bonding)
   * @return pdo l'objet de connexion
   * @throws PDOException
   */

  private static function get_connexion() {
    // Verifie si l'objet de connexion existe déjà et sinon l'instancie
    if (self::$connexion === null) {
      // Récupération des paramètres de configuration BD
      $user = Config::get_param("user");
      //$user = 'root';
      $password = Config::get_param("password", "");
      //$password = '';
      $host = Config::get_param("host");
      //$host = 'localhost';
      $base = Config::get_param("base");
      //$base = 'blogmvc';
      $dsn = 'mysql:host=' . $host . ';dbname=' . $base;
      // Instancie l'objet de connexion PDO uniuqement si c'est nécessaire
      try {
        self::$connexion = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        throw new Exception("Erreur lors de la connexion : " . $e->getMessage());
      }
    }
    // Retourne l'objet de connexion
    return self::$connexion;
  }

  /**
   * Exécute une requête SQL
   * 
   * @param string $sql Requête SQL
   * @param array $params Paramètres de la requête
   * @return PDOStatement Résultats de la requête
   */
  protected function executer($sql, $params = null) {
    try {
      if ($params == null) {
        $resultat = self::get_connexion()->query($sql);   // exécution directe
      } else {
        $resultat = self::get_connexion()->prepare($sql); // requête préparée
        $resultat->execute($params);
      }
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage()."\nSQL : ".$sql);
    }
    return $resultat;
  }

}
