<?php

require_once SRC . DS . 'models' . DS . 'Club.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';

class ClubDAO extends DAO {

  function find($Id_Club) {

    $sql = "SELECT  * FROM club WHERE Id_Club = :Id_Club";
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

  function insert(Club $Club){
    $sql = "INSERT INTO `club`(`Id_Club`, `Nom`, `AdresseClub`, `Cp`, `Ville`, `Sigle`, `NomPresident`, `Id_Ligue`) 
    VALUES (:Id_Club,:Nom,:AdresseClub,:Cp,:Ville,:Sigle,:NomPresident,:Id_Ligue)";
    try {
      $params = array(':Id_Club' => $Club->get_Id_Club(), 
                          ':Nom' => $Club->get_Nom(), 
                          ':AdresseClub' => $Club->get_AdresseClub(), 
                          ':Cp' => $Club->get_Cp(),
                          ':Ville' => $Club->get_Ville(),
                          ':Sigle' => $Club->get_Sigle(),
                          ':NomPresident' => $Club->get_NomPresident(),
                          ':Id_Ligue' => $Club->get_id_Ligue());
          $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }

  function update(Club $Club) {
    $sql = "UPDATE club set Nom=:Nom,AdresseClub=:AdresseClub,Cp=:Cp,Ville=:Ville,Sigle=:Sigle,NomPresident=:NomPresident,Id_Ligue=:Id_Ligue where Id_Club=:Id_Club";
    try {
      $params = array(':Id_Club' => $Club->get_Id_Club(), 
                          ':Nom' => $Club->get_Nom(), 
                          ':AdresseClub' => $Club->get_AdresseClub(), 
                          ':Cp' => $Club->get_Cp(),
                          ':Ville' => $Club->get_Ville(),
                          ':Sigle' => $Club->get_Sigle(),
                          ':NomPresident' => $Club->get_NomPresident(),
                          ':Id_Ligue' => $Club->get_id_Ligue());
          $sth = $this->executer($sql, $params);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $nb = $sth->rowcount();
    return $nb;  // Retourne le nombre de mise à jour
  }

  function delete(Club $Club) {
    print_r($Club);
    $sql = "DELETE from Club where Id_Club = :Id_Club ";
    try {
      $params = array(":Id_Club" => $Club->get_Id_Club());
      $sth = $this->executer($sql, $params);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
  }
}

?>