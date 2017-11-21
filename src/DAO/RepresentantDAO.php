<?php

require_once SRC . DS . 'models' . DS . 'Representant.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';

class RepresentantDAO extends DAO {

  function find($Id_Demandeur) {

    $sql = "SELECT * FROM representant WHERE Id_Demandeur = :Id_Demandeur";
      try {
          $params = array(":Id_Demandeur" => $Id_Demandeur);
          $sth = $this->executer($sql, $params);
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $representant = new Representant($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $representant;
  }

  function findAll() {

    $sql = "SELECT * FROM representant;";
      try {
          $sth = $this->executer($sql);
          $sth->execute();
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $object = array();
      foreach ($rows as $row) {
        $object = New Representant($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }
}

?>