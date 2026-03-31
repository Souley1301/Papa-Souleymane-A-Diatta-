<?php
// TOUJOURS EN HAUT : Pas d'espace ou de HTML avant cette balise
require('config.php');
require('fpdf.php');

$message_erreur = "";

if (isset($_POST['rechercher_envoi'])) {
    $id_recherche = trim($_POST['id_unique']);
    $canal = $_POST['canal'];

    $stmt = $pdo->prepare("SELECT * FROM citoyens WHERE id_citoyen = ?");
    $stmt->execute([$id_recherche]);
    $c = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($c) {
        // --- GÉNÉRATION DU PDF ---
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        
        // Correction UTF-8 pour FPDF (évite l'erreur dépréciée)
        $titre_region = iconv('UTF-8', 'windows-1252', "RÉGION DE DAKAR");
        $titre_rep = iconv('UTF-8', 'windows-1252', "RÉPUBLIQUE DU SÉNÉGAL");
        $titre_centre = iconv('UTF-8', 'windows-1252', "CENTRE DE SACRÉ-CŒUR");

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text(10, 15, $titre_region);
        $pdf->Text(10, 20, "VILLE DE DAKAR");
        $pdf->Text(10, 25, $titre_centre);
        
        $pdf->SetXY(110, 10);
        $pdf->Cell(90, 5, $titre_rep, 0, 1, 'C');
        
        // Corps de l'acte
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetY(45);
        $pdf->Cell(0, 10, "EXTRAIT D'ACTE DE NAISSANCE", 0, 1, 'C');
        
        $pdf->Rect(10, 60, 190, 130); 
        $pdf->SetXY(15, 75);
        $pdf->SetFont('Arial', '', 12);
        
        // Utilisation des données de la base (en vérifiant qu'elles existent)
        $nom = strtoupper($c['nom'] ?? 'Inconnu');
        $prenom = strtoupper($c['prenom'] ?? 'Inconnu');
        $date_sortie = date("d/m/Y");

        $corps = "Identifiant : " . $c['id_citoyen'] . "\n" .
                 "Prénom(s) : " . $prenom . "\n" .
                 "Nom : " . $nom . "\n" .
                 "Né(e) le : " . ($c['date_naiss'] ?? '') . " à " . ($c['lieu_naiss'] ?? '') . "\n" .
                 "Fils/Fille de : " . ($c['prenom_pere'] ?? '') . " " . $nom . "\n" .
                 "Et de : " . ($c['prenom_mere'] ?? '') . " " . ($c['nom_mere'] ?? '');

        $pdf->MultiCell(180, 10, iconv('UTF-8', 'windows-1252', $corps), 0, 'L');

        // --- SIGNATURE ET MAIRE ---
        $pdf->SetXY(120, 210);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 5, "Fait le : " . $date_sortie, 0, 1, 'C');
        $pdf->SetX(120);
        $pdf->Cell(80, 5, "Par : Aliou Tall (Maire)", 0, 1, 'C');
        $pdf->Rect(135, 225, 50, 25); 
        $pdf->SetXY(135, 235);
        $pdf->Cell(50, 5, "CACHET & SIGNATURE", 0, 0, 'C');

        // Sauvegarde physique
        if (!is_dir('extraits')) { mkdir('extraits', 0777, true); }
        $nom_pdf = "extraits/acte_" . $c['id_citoyen'] . ".pdf";
        $pdf->Output('F', $nom_pdf);

        // --- ENVOI ---
        $lien = "http://localhost/mairie/" . $nom_pdf;
        $msg = "Bonjour, votre extrait est prêt : " . $lien;

        if ($canal == 'whatsapp') {
            $url = "https://api.whatsapp.com/send?phone=" . $c['whatsapp'] . "&text=" . urlencode($msg);
        } else {
            $url = "mailto:" . $c['email'] . "?subject=Extrait&body=" . urlencode($msg);
        }
        
        header("Location: $url");
        exit();
    } else {
        $message_erreur = "Identifiant introuvable.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Récupération Extrait</title>
    <style>
        body { font-family: Arial; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; }
        input, select, button { width: 100%; padding: 12px; margin: 10px 0; border-radius: 6px; border: 1px solid #ccc; }
        button { background: #1a42bb; color: white; font-weight: bold; cursor: pointer; border: none; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Mon Extrait Officiel</h3>
        <?php if($message_erreur) echo "<p style='color:red'>$message_erreur</p>"; ?>
        <form method="POST">
            <input type="text" name="id_unique" placeholder="Entrez votre ID (ex: REG-123)" required>
            <select name="canal">
                <option value="whatsapp">WhatsApp</option>
                <option value="email">E-mail</option>
            </select>
            <button type="submit" name="rechercher_envoi">Générer et Envoyer</button>
        </form>
    </div>
</body>
</html>