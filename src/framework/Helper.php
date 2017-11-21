<?php

/**
 * Classe Helper
 * 
 * Classe fourre-tout qui contient des méthodes utilitaires
 * @author jef
 */
class Helper {

  /**
   * Convertit des dates
   * @param string $date1 date à convertir
   * @param string $format le code de conversion (1=dd/mm/yy -> yy-mm-dd, 2=yy-mm-dd -> dd/mm/yy)
   * @return string date à convertir
   */
  static function format_date($date, $format) {
    $date1 = trim($date);
    $date2 = "";
    switch ($format) {
      // dd/mm/yy -> yy-mm-dd
      case "1" :
        $tableau = explode('/', $date1);
        $date2 = $tableau[2] . '-' . $tableau[1] . '-' . $tableau[0];
        break;
      case "2" :
        // yy-mm-dd -> dd/mm/yy
        $tableau = explode('-', $date1);
        $date2 = $tableau[2] . '/' . $tableau[1] . '/' . $tableau[0];
        break;
      default:
        $date2 = "???";
        break;
    }
    return $date2;
  }

  /**
   * Convertit des dates horodatées (datetime) dans un format français
   * @param string $date1 date à convertir
   * @param string $format le code de conversion (1=dd/mm/yy -> yy-mm-dd, 2=yy-mm-dd -> dd/mm/yy)
   * @return string date à convertir
   */
  static function format_datetime($datetime) {
    $date2 = "";
    // yyyy-mm-dd hh:mn:ss -> dd/mm/yyyy à hh:mn:ss
    $date1 = substr(trim($datetime), 0, 10);
    $time1 = substr(trim($datetime), 11, 8);
    $tableau = explode('-', $date1);
    $date2 = $tableau[2] . '/' . $tableau[1] . '/' . $tableau[0];
    $date2 = $date2 . ' à ' . $time1;
    return $date2;
  }

  /**
   * Retourne la date système dans le fuseau français
   * @return \DateTime la date système
   */
  static function get_sysdate() {
    $dateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));
    return $dateTime;
  }

  /**
   * Convertit une chaîne Camel Case en Snake Case (EstParti -> est_parti)
   * https://stackoverflow.com/questions/1993721/how-to-convert-camelcase-to-camel-case
   * @param string $string La chaîne à convertir
   * @return string La chaîne convertie
   */
  static function camel_to_snake($string) {
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
  }

  /**
   * Convertit une chaîne Snake Case en Camel Case (est_parti -> estParti )
   * https://codereview.stackexchange.com/questions/48593/converting-snake-case-to-pascalcase
   * @param string $string
   * @return string
   */
  static function snake_to_camel($string) {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
  }

}

// class Helper
