<?php

require_once SRC . DS . 'models' . DS . 'Indemnite.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';

class IndemniteDAO extends DAO {

  function find($Annee) {

    $sql = "SELECT * FROM indemnite WHERE Annee = :Annee";
      try {
        $params = array(':Annee' => $Annee);
        $sth = $this->executer($sql, $params);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $indemnite = new Indemnite($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $indemnite;
  }

  function findAll() {

    $sql = "SELECT * FROM indemnite;";
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

  function findYearByCurrentYear(){
    $sql = "SELECT Annee FROM indemnite WHERE Annee = :Annee";
      try {
        $params = array(':Annee' => date('y'));
        $sth = $this->executer($sql, $params);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
    
      foreach ($row as $key => $value) {
          $row = $value;
      }      
      return $row;
  }
}

?>