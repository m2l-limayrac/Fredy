<?php

/**
 * Dao Demandeur 
 *
 * @author jef
 */
require_once SRC . DS . 'framework' . DS . 'DAO.php';
require_once SRC . DS . 'framework' . DS . 'Flash.php';
require_once SRC . DS . 'models' . DS . 'Lignefrais.php';
require_once SRC . DS . 'DAO' . DS . 'MotifDAO.php';
require_once SRC . DS . 'models' . DS . 'Motif.php';


class LigneFraisDAO extends DAO {

  private static $MotifDAO;

  function find($id_Ligne) {
    $sql = "SELECT * FROM lignefrais WHERE id_Ligne=:id_Ligne";
    try {
      $params = array(":id_Ligne" => $id_Ligne);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $ligne = new LigneFrais($row);   
    if(SELF::$MotifDAO == null){
      SELF::$MotifDAO = new MotifDAO();
    }
    $ligne->set_Motif(SELF::$MotifDAO->findByLigne($ligne->get_Id_Ligne()));
    return $ligne; // Retourne l'objet métier
  }

  function findMotif($id_Ligne) {
    $sql = "SELECT lignefrais FROM lignefrais WHERE id_Ligne=:id_Ligne";
    try {
      $params = array(":id_Ligne" => $id_Ligne);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    $ligne = new LigneFrais($row);   
    
    return $ligne; // Retourne l'objet métier
  }

  function findAllByMail($AdresseMail) {
    $sql = "SELECT * FROM demandeur WHERE AdresseMail=:AdresseMail";
    try {
      $params = array(":AdresseMail" => $AdresseMail);
      $sth = $this->executer($sql, $params);
      $row = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
    }
    if($row != false){
      $demandeur = new Demandeur($row);
      /*if(SELF::$MotifDAO == null){
        SELF::$MotifDAO = new MotifDAO();
      }*/

      $demandeur->set_les_notes($this->findNoteDeFrais($demandeur->get_Id_Demandeur()));      
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

    $objects = array();
    foreach ($rows as $row) {
      $object = New Demandeur($row);
      $les_notes = $this->findNoteDeFrais($object->get_Id_Demandeur());
      $objects[] = $object;
    }

    return $objects;
  }
  
  function insert(LigneFrais $ligneFrais){
    //GLOBAL $con;

    $sql = "INSERT INTO  lignefrais (Date ,  Km ,  CoutPeage ,  CoutRepas ,  CoutHebergement ,  Trajet ,  Annee ,  Id_Motif ) VALUES (:Date, :Km, :CoutPeage, :CoutRepas, :CoutHebergement, :Trajet, :Annee, :Id_Motif)";
    try {
        $params = array(':Date' => $ligneFrais->get_Date(),
                        ':Km' => $ligneFrais->get_Km(),
                        ':CoutPeage' => $ligneFrais->get_CoutPeage(),
                        ':CoutRepas' => $ligneFrais->get_CoutRepas(),
                        ':CoutHebergement' => $ligneFrais->get_CoutHebergement(),
                        ':Trajet' => $ligneFrais->get_Trajet(),
                        ':Annee' => $ligneFrais->get_Annee(),
                        ':Id_Motif' => $ligneFrais->get_Motif());

        $sth = $this->executer($sql, $params);
        $return = SELF::$connexion->lastInsertId();
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  return $return;
}


  function update(LigneFrais $ligneFrais){
    //GLOBAL $con;
    
    $sql = "UPDATE lignefrais SET id_Ligne = :id_Ligne, Date = :Date, Km = :Km, CoutPeage = :CoutPeage, CoutRepas = :CoutRepas, CoutHebergement = :CoutHebergement, Trajet = :Trajet, Id_Motif = :Id_Motif WHERE id_Ligne = :id_Ligne";
      try {
          $params = array(':id_Ligne' => $ligneFrais->get_id_Ligne(), 
                              ':Date' => $ligneFrais->get_Date(),
                              ':Km' => $ligneFrais->get_Km(),
                              ':CoutPeage' => $ligneFrais->get_CoutPeage(),
                              ':CoutRepas' => $ligneFrais->get_CoutRepas(),
                              ':CoutHebergement' => $ligneFrais->get_CoutHebergement(),
                              ':Trajet' => $ligneFrais->get_Trajet(),
                              //':Annee' => $ligneFrais->get_Annee(),
                              ':Id_Motif' => $ligneFrais->get_Motif());
          $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }
  }

  function delete (LigneFrais $ligneFrais){
    //GLOBAL $con;
    
    $sql = "DELETE FROM lignefrais WHERE id_Ligne = :id_Ligne";
      try {
        $params = array(':id_Ligne' => $ligneFrais->get_id_Ligne());
        $sth = $this->executer($sql, $params);
      } catch (PDOException $ex) {
          die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
      }        
  }
  
  function findNoteDeFrais($Id_Demandeur) {
    $sql = "SELECT Id_NoteDeFrais FROM avancer WHERE Id_Demandeur = :Id_Demandeur";
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
    return $notes; // Retourne l'objet métier
  }

  function insertAvance($Id_Demandeur, $Id_Ligne, $Id_NoteDeFrais){
    $sql = "INSERT INTO  avancer (Id_Demandeur, Id_Ligne, Id_NoteDeFrais ) VALUES (:Id_Demandeur, :Id_Ligne, :Id_NoteDeFrais)";
    try {
        $params = array(':Id_Demandeur' => $Id_Demandeur,
                        ':Id_Ligne' => $Id_Ligne,
                        ':Id_NoteDeFrais' => $Id_NoteDeFrais);

        $sth = $this->executer($sql, $params);
    } catch (PDOException $ex) {
        die("Erreur lors de l'execution de la requette : ".$ex->getMessage());
    }
  }

}
