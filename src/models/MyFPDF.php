<?php

//
// Extension de la classe FPDF
//
require_once SRC . DS . 'models' . DS . 'fpdf'.DS.'fpdf.php';

/**
 * Description of MyFPDF
 *
 * @author jef
 */
class MyFPDF extends FPDF {

  /**
   * Implémentation de l'entête
   */
  function Header() {
    // Date du jour
    $dateTime = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $created = $dateTime->format('d/m/Y');
    $this->SetFont('Arial', '', 8);
    $this->Cell(50, 5, c("PPE"), "B", 0, 'L');
    $this->Cell(90, 5, c("Cerfa"), "B", 0, 'C');
    $this->Cell(50, 5, c($created), "B", 1, 'R');
  }

  /**
   * Implémentation du bas de page
   */
  function Footer() {
    $this->SetY(-15);
    $this->SetFont('Arial', '', 8);
    $this->Cell(50, 5, c("Institut Limayrac - Pinet, Lapeze, Roussel"), "T", 0, 'L');
    $this->Cell(90, 5, c(".pdf"), "T", 0, 'C');
    $this->Cell(50, 5, c("Page " . $this->PageNo()), "T", 1, 'R');
  }
}