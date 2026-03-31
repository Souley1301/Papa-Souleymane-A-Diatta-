<?php
// Inclusion de la bibliothèque FPDF
require('fpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. RÉCUPÉRATION ET FORMATAGE DES DONNÉES
    $nom_enfant = strtoupper($_POST['nom_enfant']);
    $prenom_enfant = strtoupper($_POST['prenom_enfant']);
    $sexe = $_POST['sexe'];
    $date_naiss = $_POST['date_naiss'];
    $heure_naiss = $_POST['heure_naiss'];
    $lieu_naiss = strtoupper($_POST['lieu_naiss']);
    $prenom_pere = strtoupper($_POST['prenom_pere']);
    $prenom_mere = strtoupper($_POST['prenom_mere']);
    $nom_mere = strtoupper($_POST['nom_mere']);

    // 2. STOCKAGE DES DONNÉES (Exigence NB: Fopen, Fput) 
    $ligne = "$nom_enfant|$prenom_enfant|$date_naiss|$lieu_naiss|$prenom_pere|$prenom_mere\n";
    $fichier = fopen("registre_declarations.txt", "a");
    if ($fichier) {
        fputs($fichier, $ligne);
        fclose($fichier);
    }

    // 3. CRÉATION DU PDF OPTIMISÉ 
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(false);

    // --- EN-TÊTE ---
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(10, 10);
    $pdf->MultiCell(60, 4, utf8_decode("REGION DE DAKAR\nVILLE DE DAKAR\nCENTRE DE SACRÉ-CŒUR"), 0, 'L');

    $pdf->SetXY(110, 10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(90, 4, utf8_decode("RÉPUBLIQUE DU SÉNÉGAL"), 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 7);
    $pdf->Cell(290, 4, "UN PEUPLE - UN BUT - UNE FOI", 0, 1, 'C');

    // --- CADRE ANNÉE ET REGISTRE (En haut à droite) ---
    $pdf->Rect(150, 40, 50, 25); 
    $pdf->SetXY(150, 43);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(50, 5, "An  " . date('Y'), 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetX(150);
    $pdf->Cell(50, 10, "N / " . rand(100, 999), 0, 1, 'C');

    // --- TITRE ---
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetY(55);
    $pdf->Cell(190, 10, "EXTRAIT DU REGISTRE DES ACTES DE NAISSANCE", 0, 1, 'C');

    // --- CORPS DE L'ACTE (CADRE CENTRAL) ---
    $pdf->Rect(10, 75, 190, 115); // Grand cadre 

    // Lignes de séparation horizontales
    $pdf->Line(10, 115, 200, 115); 
    $pdf->Line(10, 150, 200, 150);

    // Détails de naissance
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(15, 80);
    $pdf->MultiCell(180, 7, utf8_decode("Le $date_naiss à $heure_naiss\nest né(e) à $lieu_naiss\nUn enfant de sexe $sexe"), 0, 'L');

    // Identité Enfant
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetXY(15, 122);
    $pdf->Cell(90, 10, "PRENOM(S) : $prenom_enfant", 0, 0);
    $pdf->Cell(90, 10, "NOM : $nom_enfant", 0, 1);

    // Identité Parents
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(15, 158);
    $pdf->Cell(0, 7, utf8_decode("FILS/FILLE DE : $prenom_pere $nom_enfant"), 0, 1);
    $pdf->Cell(0, 7, utf8_decode("ET DE : $prenom_mere $nom_mere"), 0, 1);

    // --- SIGNATURE ET CACHET ---
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetXY(110, 200);
    $pdf->Cell(80, 5, "POUR EXTRAIT CERTIFIE CONFORME", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetX(110);
    $pdf->Cell(80, 5, utf8_decode("Fait à Sacré-Cœur, le ") . date('d/m/Y'), 0, 1, 'C');

    // 4. AFFICHAGE DU PDF
    $pdf->Output('I', 'Acte_Naissance.pdf');
}
?>