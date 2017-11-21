<?php

/**
 * Classe modélisant les paramètres de configuration
 * 
 * @author J.F. Ramiara
 */
class Config {

  private static $params; // Tableau des paramètres lus dans le fichier .ini
  const DEV = SRC.DS."config".DS."dev.ini";
  const PROD = SRC.DS."config".DS."prod.ini";

  /**
   * Renvoie la valeur d'un paramètre de configuration
   * 
   * @param string $nom Nom du paramètre
   * @param string $defaut Valeur à renvoyer par défaut
   * @return string Valeur du paramètre
   * TODO : gérer les sections INI
   */
  public static function get_param($nom, $defaut = null) {
    if (isset(self::get_params()[$nom])) {
      $valeur = self::get_params()[$nom];
    } else {
      $valeur = $defaut;
    }
    return $valeur;
  }

  /**
   * Renvoie le tableau des paramètres en le chargeant au besoin depuis le fichier .ini
   * @return array Tableau des paramètres
   * @throws Exception Si aucun fichier de configuration n'est trouvé
   */
  private static function get_params() {
    if (self::$params == null) {
      if (!file_exists(self::DEV) && !file_exists(self::PROD)) {
        throw new Exception("Aucun fichier de configuration trouvé : " . self::DEV . ", " . self::PROD);
      }
      if (file_exists(self::PROD)) {
        self::$params = parse_ini_file(self::PROD);
      } else {
        self::$params = parse_ini_file(self::DEV);
      }
    }
    return self::$params;
  }

}
