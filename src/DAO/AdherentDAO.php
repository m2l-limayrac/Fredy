<?php

require_once SRC . DS . 'models' . DS . 'Adherent.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';
require_once SRC . DS . 'models' . DS . 'Demandeur.php';
require_once SRC . DS . 'models' . DS . 'Club.php';
require_once SRC . DS . 'DAO' . DS . 'ClubDAO.php';



class AdherentDAO extends DAO {

  private static $ClubDAO;


  function find($numLicence) {

      try {
          $sql = "SELECT * FROM adherent WHERE numLicence = :numLicence";
          $params = array(':numLicence' => $numLicence);
          $sth = $this->executer($sql, $params);
          $row = $sth->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      
      $adherent = new Adherent($row);
      if(SELF::$ClubDAO == null){
        SELF::$ClubDAO = new ClubDAO();
      }
      $adherent->set_Club(SELF::$ClubDAO->find($adherent->get_Id_Club()));
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
      if(SELF::$ClubDAO == null){
        SELF::$ClubDAO = new ClubDAO();
      }
      $adherent->set_Club(SELF::$ClubDAO->find($adherent->get_Id_Club()));
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
        if(SELF::$ClubDAO == null){
        SELF::$ClubDAO = new ClubDAO();
      }
      $objects = array();
      foreach ($rows as $row) {
        $object = New Adherent($row);
        $object->set_Club(SELF::$ClubDAO->find($object->get_Id_Club()));
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
        if(SELF::$ClubDAO == null){
        SELF::$ClubDAO = new ClubDAO();
      }
      $object = array();
      foreach ($rows as $row) {
        $object = New Adherent($row);
        $object->set_Club(SELF::$ClubDAO->find($adherent->get_Id_Club()));
        //echo "<pre>"; print_r($object); echo "</pre>";
        $objects[] = $object;
      }

      return $objects;     
  }

  function insert(Adherent $Adherent){
    $sql = "INSERT INTO `adherent`(`numLicence`, `Nom`, `Prenom`, `Sexe`, `DateNaissance`, `AdresseAdh`, `CP`, `Ville`, `Id_Demandeur`, `Id_Club`) VALUES (:numLicence,:Nom,:Prenom,:Sexe,:DateNaissance,:AdresseAdh,:CP,:Ville,:Id_Demandeur,:Id_Club)";
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
                          ':Id_Club' => $Adherent->get_Id_Club());
          $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }

  function update(Adherent $Adherent) {
    $sql = "UPDATE adherent set numLicence = :numLicence, Nom=:Nom,Prenom=:Prenom,Sexe=:Sexe,DateNaissance=:DateNaissance,AdresseAdh=:AdresseAdh,CP=:CP,Ville=:Ville, Id_Club=:Id_Club where Id_Demandeur=:Id_Demandeur";
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
                          ':Id_Club' => $Adherent->get_Id_Club());
      $sth = $this->executer($sql, $params);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $nb = $sth->rowcount();
    return $nb;  // Retourne le nombre de mise à jour
  }

  function delete($numLicence) {
    $sql = "delete from adherent where numLicence=:numLicence";
    try {
      $params = array(':numLicence' => $numLicence);
      $sth = $this->executer($sql, $params);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $nb = $sth->rowcount();
    return $nb;  // Retourne le nombre de suppression
  }
}

?>