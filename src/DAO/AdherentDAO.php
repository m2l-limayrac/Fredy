<?php

require_once SRC . DS . 'models' . DS . 'Adherent.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';
require_once SRC . DS . 'models' . DS . 'Demandeur.php';



class AdherentDAO extends DAO {


  function find($id_adherent) {

      try {
          $sql = "SELECT * FROM adherent WHERE id_adherent = :id_adherent";
          $params = array(':id_adherent' => $id_adherent);
          $sth = $this->executer($sql, $params);
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $adherent = new Adherent($row);
      
      return $adherent;
  }

  function findByDemandeur($Id_Demandeur) {

      try {
          $sql = "SELECT * FROM adherent WHERE Id_Demandeur = :Id_Demandeur";
          $params = array(':Id_Demandeur' => $Id_Demandeur);
          $sth = $this->executer($sql, $params);
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $adherent = new Adherent($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $adherent;
  }

  function findDemandeur(Adherent $adherent) {

      try {
          $sql = "SELECT D.Id_Demandeur, D.AdresseMail, D.MotDePasse FROM demandeur D, adherent A WHERE A.Id_Demandeur = D.Id_Demandeur AND A.numLicence = :numLicence";
          $params = array(':numLicence' => $adherent->get_numLicence());
          $sth = $this->executer($sql, $params);
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $demandeur = new Demandeur($row);
/*      echo "<pre>"; print_r($pizza); echo "</pre>";*/
      return $demandeur;
  }

  function findAllByDemandeur($Id_Demandeur) {

    $sql = "SELECT * from adherent WHERE Id_Demandeur = :Id_Demandeur;";
      try {
          $params = array(':Id_Demandeur' => $Id_Demandeur);
          $sth = $this->executer($sql, $params);
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
      $objects = array();
      foreach ($rows as $row) {
        $object = New Adherent($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

  function findAll() {

    $sql = "SELECT * FROM adherent;";
      try {
          $sth = $this->executer($sql);
          $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      } 
        
      $object = array();
      foreach ($rows as $row) {
        $object = New Adherent($row);
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

  function insert(Adherent $Adherent){
    $sql = "INSERT INTO `adherent`(`numLicence`, `Nom`, `Prenom`, `Sexe`, `DateNaissance`, `AdresseAdh`, `CP`, `Ville`, `Id_Demandeur`) VALUES (:numLicence,:Nom,:Prenom,:Sexe,:DateNaissance,:AdresseAdh,:CP,:Ville,:Id_Demandeur)";
    try {
      $params = array(':numLicence' => $Adherent->get_numLicence(), 
                          ':Nom' => $Adherent->get_Nom(), 
                          ':Prenom' => $Adherent->get_Prenom(), 
                          ':Sexe' => $Adherent->get_Sexe(),
                          ':DateNaissance' => $Adherent->get_DateNaissance(),
                          ':AdresseAdh' => $Adherent->get_AdresseAdh(),
                          ':CP' => $Adherent->get_CP(),
                          ':Ville' => $Adherent->get_Ville(),
                          ':Id_Demandeur' => $Adherent->get_Id_Demandeur());
          $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }

  function update(Adherent $Adherent) {
    $sql = "UPDATE adherent set numLicence = :numLicence, Nom=:Nom,Prenom=:Prenom,Sexe=:Sexe,DateNaissance=:DateNaissance,AdresseAdh=:AdresseAdh,CP=:CP,Ville=:Ville, Id_Demandeur = :Id_Demandeur where id_adherent=:id_adherent";
    try {
      $params = array(':numLicence' => $Adherent->get_numLicence(), 
                          ':Nom' => $Adherent->get_Nom(), 
                          ':Prenom' => $Adherent->get_Prenom(), 
                          ':Sexe' => $Adherent->get_Sexe(),
                          ':DateNaissance' => $Adherent->get_DateNaissance(),
                          ':AdresseAdh' => $Adherent->get_AdresseAdh(),
                          ':CP' => $Adherent->get_CP(),
                          ':Ville' => $Adherent->get_Ville(),
                          ':Id_Demandeur' => $Adherent->get_Id_Demandeur(),
                          ':id_adherent' => $Adherent->get_id_adherent());
      $sth = $this->executer($sql, $params);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $nb = $sth->rowcount();
    return $nb;  // Retourne le nombre de mise à jour
  }

  function delete($id_adherent) {
    $sql = "delete from adherent where id_adherent=:id_adherent";
    try {
      $params = array(':id_adherent' => $id_adherent);
      $sth = $this->executer($sql, $params);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $nb = $sth->rowcount();
    return $nb;  // Retourne le nombre de suppression
  }
}

?>