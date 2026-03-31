<?php
require('fpdf.php');

// 1. Initialisation (Format Portrait, millimètres, A4)
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

// --- EN-TÊTE OFFICIEL ---
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetXY(10, 10);
$pdf->MultiCell(60, 4, utf8_decode("REGION DE DAKAR\nVILLE DE DAKAR\n\nCENTRE DE SACRÉ-CŒUR"), 0, 'L');

$pdf->SetXY(110, 10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 4, utf8_decode("RÉPUBLIQUE DU SÉNÉGAL"), 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(290, 4, "UN PEUPLE - UN BUT - UNE FOI", 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(290, 10, "ETAT- CIVIL", 0, 1, 'C');

// --- REGISTRE ET ANNÉE (CADRE À DROITE) ---
$pdf->Rect(150, 50, 50, 30); 
$pdf->SetXY(150, 55);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 5, "An  " . date('Y'), 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetX(150);
$pdf->Cell(50, 10, "N / Réf", 0, 1, 'C');

// --- TITRE PRINCIPAL ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetY(50);
$pdf->Cell(190, 10, "EXTRAIT DU REGISTRE DES ACTES DE NAISSANCE", 'T', 1, 'C');

// --- CORPS DE L'ACTE (GRAND CADRE DE PROTECTION) ---
$pdf->Rect(10, 90, 190, 110); 

// Lignes de séparation internes (Comme sur le modèle image_c368ca.jpg)
$pdf->Line(10, 125, 200, 125); // Séparation Enfant / Parents
$pdf->Line(10, 160, 200, 160); // Séparation Père / Mère

// Données de Naissance
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(15, 95);
$pdf->MultiCell(180, 8, utf8_decode("Le : " . $_POST['date_naiss'] . " à " . $_POST['heure_naiss'] . "\nest né(e) à : " . strtoupper($_POST['lieu_naiss']) . "\nUn enfant de sexe : " . $_POST['sexe']), 0, 'L');

// Identité de l'Enfant
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetXY(15, 135);
$pdf->Cell(90, 10, "PRENOM(S) : " . strtoupper($_POST['prenom_enfant']), 0, 0);
$pdf->Cell(90, 10, "NOM : " . strtoupper($_POST['nom_enfant']), 0, 1);

// Informations des Parents
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(15, 170);
$pdf->Cell(0, 8, utf8_decode("De : " . strtoupper($_POST['prenom_pere']) . " " . strtoupper($_POST['nom_enfant'])), 0, 1);
$pdf->Cell(0, 8, utf8_decode("Et de : " . strtoupper($_POST['prenom_mere']) . " " . strtoupper($_POST['nom_mere'])), 0, 1);

// --- ZONE DE SIGNATURE ET CACHET ---
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetXY(110, 215);
$pdf->Cell(80, 5, "POUR EXTRAIT CERTIFIE CONFORME", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->SetX(110);
$pdf->Cell(80, 5, utf8_decode("À SACRÉ-CŒUR, le ") . date('d/m/Y'), 0, 1, 'C');

// Option : Ajouter le logo de la mairie en petit en bas
// $pdf->Image('logo_mairie.png', 140, 230, 25);

// 2. SORTIE DU PDF
$pdf->Output('I', 'Acte_Naissance_Declare.pdf');
?>