<?php

require_once SRC . DS . 'models' . DS . 'Ligue.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';

class LigueDAO extends DAO {


  function find($Id_Ligue) {

    $sql = "SELECT * FROM ligue WHERE Id_Ligue = :Id_Ligue";
      try {
        $params = array(':Id_Ligue' => $Id_Ligue);
        $sth = $this->executer($sql, $params);
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
          $sth = $this->executer($sql);
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