<?php

require_once SRC . DS . 'models' . DS . 'Indemnite.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';

class IndemniteDAO extends DAO {

  function find($Id_Ligne) {

    $sql = "SELECT * FROM club WHERE Id_Club = :Id_Club";
      try {
        $params = array(':Id_Club' => $Id_Club);
        $sth = $this->executer($sql, $params);
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
          $sth = $this->executer($sql);
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
}

?>