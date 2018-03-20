<?php

/**
 * Dao Demandeur 
 *
 * @author jef
 */
require_once SRC . DS . 'models' . DS . 'Demandeur.php';
require_once SRC . DS . 'framework' . DS . 'DAO.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'DAO' . DS . 'NoteDeFraisDAO.php';
require_once SRC . DS . 'DAO' . DS . 'RepresentantDAO.php';
require_once SRC . DS . 'DAO' . DS . 'AdherentDAO.php';
require_once SRC . DS . 'models' . DS . 'NoteDeFrais.php';
require_once SRC . DS . 'models' . DS . 'Representant.php';
require_once SRC . DS . 'models' . DS . 'Adherent.php';
require_once SRC . DS . 'models' . DS . 'Club.php';
require_once SRC . DS . 'DAO' . DS . 'ClubDAO.php';


class DemandeurDAO extends DAO {

  private static $NoteDeFraisDAO;
  private static $RepresentantDAO;
  private static $AdherentDAO;
  private static $ClubDAO;

  function find($Id_Demandeur) {
    
    $sql = "SELECT * FROM demandeur WHERE Id_Demandeur = :Id_Demandeur";
    try {
      $params = array(":Id_Demandeur" => $Id_Demandeur);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    $demandeur = new Demandeur($row);
    if(SELF::$NoteDeFraisDAO == null){
      SELF::$NoteDeFraisDAO = new NoteDeFraisDAO();
    }

    if(SELF::$RepresentantDAO == null){
      SELF::$RepresentantDAO = new RepresentantDAO();
    }

    $demandeur->set_les_notes($this->findNoteDeFrais($demandeur->get_Id_Demandeur()));

    if(SELF::$ClubDAO == null){
      SELF::$ClubDAO = new ClubDAO();
    }
    $demandeur->set_Club(SELF::$ClubDAO->find($demandeur->get_Id_Club()));


    if($demandeur->get_isRepresentant()){
        if(SELF::$RepresentantDAO == null){
          SELF::$RepresentantDAO = new RepresentantDAO();
        }
        $demandeur->set_Representant(SELF::$RepresentantDAO->find($demandeur->get_Id_Demandeur()));
      }else{
        if(SELF::$AdherentDAO == null){
          SELF::$AdherentDAO = new AdherentDAO();
        }
        $demandeur->set_Adherent(SELF::$AdherentDAO->findByDemandeur($demandeur->get_Id_Demandeur()));
      }
    /*if($demandeur->get_isRepresentant()){
      $demandeur->set_les_adherents(SELF::$AdherentDAO->findAllByDemandeur($demandeur->get_Id_Demandeur()));
    }*/
    
    return $demandeur; // Retourne l'objet métier
  }



  function findAllByMail($AdresseMail) {
    $sql = "SELECT DISTINCT * FROM demandeur WHERE AdresseMail=:AdresseMail";
    try {
      $params = array(":AdresseMail" => $AdresseMail);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    if($row != false){
      $demandeur = new Demandeur($row);
      /*if(SELF::$NoteDeFraisDAO == null){
        SELF::$NoteDeFraisDAO = new NoteDeFraisDAO();
      }*/
      if(SELF::$RepresentantDAO == null){
        SELF::$RepresentantDAO = new RepresentantDAO();
      }
      $demandeur->set_les_notes($this->findNoteDeFrais($demandeur->get_Id_Demandeur()));

      if(SELF::$ClubDAO == null){
        SELF::$ClubDAO = new ClubDAO();
      }
      $demandeur->set_Club(SELF::$ClubDAO->find($demandeur->get_Id_Club()));

      if($demandeur->get_isRepresentant()){
        if(SELF::$RepresentantDAO == null){
          SELF::$RepresentantDAO = new RepresentantDAO();
        }
        $demandeur->set_Representant(SELF::$RepresentantDAO->find($demandeur->get_Id_Demandeur()));
      }else{
        if(SELF::$AdherentDAO == null){
          SELF::$AdherentDAO = new AdherentDAO();
        }
        $demandeur->set_Adherent(SELF::$AdherentDAO->findByDemandeur($demandeur->get_Id_Demandeur()));
      }

    }else{
      $row = array();
    }
    
    return $demandeur; // Retourne l'objet métier
  }

  /**
   * Lecture de toutes les chaloupes
   */
  function findAll() {
    $sql = "SELECT * FROM demandeur";
    try { 
      $sth = $this->executer($sql);
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    if(SELF::$ClubDAO == null){
      SELF::$ClubDAO = new ClubDAO();
    }

    $objects = array();
    foreach ($rows as $row) {
      $object = New Demandeur($row);
      $les_notes = $this->findNoteDeFrais($object->get_Id_Demandeur());
      $object->set_Club(SELF::$ClubDAO->find($object->get_Id_Club()));
      $objects[] = $object;
    }


    return $objects;
  }
  
  function insert(Demandeur $demandeur){
    //GLOBAL $con;
    if($demandeur->get_isRepresentant()){
      $isRepresentant = '1';
    }else{
      $isRepresentant = '0';
    }
    $sql = "INSERT INTO `demandeur`(`AdresseMail`, `MotDePasse`, `Id_Club`, `isRepresentant`) VALUES (:AdresseMail, :MotDePasse, :Id_Club, :isRepresentant)";
    try {
        $params = array(':AdresseMail' => $demandeur->get_AdresseMail(), 
                        ':MotDePasse' => $demandeur->get_MotDePasse(),
                        ':Id_Club' => $demandeur->get_Id_Club(),
                        ':isRepresentant' => $isRepresentant);

        $sth = $this->executer($sql, $params);
        $return = SELF::$connexion->lastInsertId();
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
    return $return;
}

  function update(Demandeur $demandeur){
    //GLOBAL $con;
    
    $sql = "UPDATE demandeur SET Id_Demandeur = :Id_Demandeur, AdresseMail = :AdresseMail, MotDePasse = :MotDePasse, Id_Club = :Id_Club, isRepresentant = :isRepresentant WHERE Id_Demandeur = :Id_Demandeur";
      try {
          $params = array(':Id_Demandeur' => $demandeur->get_Id_Demandeur(), 
                              ':AdresseMail' => $demandeur->get_AdresseMail(), 
                              ':MotDePasse' => $demandeur->get_MotDePasse(),
                              ':Id_Club' => $demandeur->get_Id_Club(),
                              ':isRepresentant' => $demandeur->get_int_isRepresentant());
          $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
      if($demandeur->get_isRepresentant()){
         if(SELF::$RepresentantDAO == null){
          SELF::$RepresentantDAO = new RepresentantDAO();
        }
        SELF::$RepresentantDAO->update($demandeur->get_Representant());
      }else{
        if(SELF::$AdherentDAO == null){
          SELF::$AdherentDAO = new AdherentDAO();
        }
        SELF::$AdherentDAO->update($demandeur->get_Adherent());

      }
  }

  function delete (Demandeur $demandeur){
    //GLOBAL $con;
    
    $sql = "DELETE FROM demandeur WHERE Id_Demandeur = :Id_Demandeur";
      try {
        $params = array(':Id_Demandeur' => $demandeur->get_Id_Demandeur());
        $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }        
  }
  
  function findNoteDeFrais($Id_Demandeur) {
    $sql = "SELECT DISTINCT N.* FROM avancer A, notedefrais N WHERE A.Id_NoteDeFrais = N.Id_NoteDeFrais AND Id_Demandeur = :Id_Demandeur";
    try {
      $params = array(":Id_Demandeur" => $Id_Demandeur);
      $sth = $this->executer($sql, $params);
      $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $notes = array();
    foreach ($rows as $row) {
      $NoteDeFrais = new NoteDeFrais($row);
      $notes[] = $NoteDeFrais;
    }
    if(SELF::$NoteDeFraisDAO == null){
      SELF::$NoteDeFraisDAO = new NoteDeFraisDAO();
    }
    foreach ($notes as $note) {
      $note->set_les_lignes(SELF::$NoteDeFraisDAO->findLigneDeFrais($note->get_Id_NoteDeFrais()));
    }

    return $notes; // Retourne l'objet métier
  }

}
