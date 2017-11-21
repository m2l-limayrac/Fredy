<?php

require_once SRC . DS . 'models' . DS . 'Motif.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';


class MotifDAO extends DAO {

  function find($Id_Motif) {

    $sql = "SELECT * FROM motif WHERE Id_Motif = :Id_Motif";
      try {
          $params = array(':Id_Motif' => $Id_Motif);
          $sth = $this->executer($sql, $params);
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $motif = new Motif($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $motif;
  }

  function findAll() {

    $sql = "SELECT * FROM motif;";
      try {
        $sth = $this->executer($sql);
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $object = array();
      foreach ($rows as $row) {
        $object = New Motif($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

  function insert(Motif $Motif){
    $sql = "INSERT INTO `motif`(`Id_Motif`, `Libelle`) VALUES (:Id_Motif,:Libelle)";
    try {
      $params = array(':Id_Motif' => $Motif->get_Id_Motif(), 
                      ':Libelle' => $Motif->get_Libelle());
      $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }

  function update(Motif $Motif){
    $sql = "UPDATE motif set Id_Motif=:Id_Motif , Libelle=:Libelle";
    //$sql = "SHOW CREATE TABLE motif";
    try {
      $params = array(':Id_Motif' => $Motif->get_Id_Motif(), 
                          ':Libelle' => $Motif->get_Libelle());
      $sth = $this->executer($sql, $params);
       $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
    echo "<pre>"; print_r($row); echo "</pre>";
  }

  function delete(Motif $Motif){
    $sql = "DELETE FROM `motif` WHERE `Id_Motif` = :Id_Motif";
    try {
     $params = array(':Id_Motif' => $Motif->get_Id_Motif());
      $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }


}
