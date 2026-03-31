<?php
require('config.php');
require('fpdf.php');

// --- CAS 1 : ENREGISTREMENT (Déclaration de naissance) ---
if (isset($_POST['enregistrer'])) {
    $id = "REG-" . time(); // Génération de la Clé Primaire
    $nom_e = strtoupper($_POST['nom_enfant']);
    $prenom_e = strtoupper($_POST['prenom_enfant']);
    $sexe = $_POST['sexe'];
    $date_n = $_POST['date_naiss'];
    $heure_n = $_POST['heure_naiss'];
    $lieu_n = strtoupper($_POST['lieu_naiss']);
    $p_pere = strtoupper($_POST['prenom_pere']);
    $p_mere = strtoupper($_POST['prenom_mere']);
    $n_mere = strtoupper($_POST['nom_mere']);
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];

    // Insertion SQL
    $sql = "INSERT INTO citoyens (id_citoyen, nom, prenom, sexe, date_naiss, heure_naiss, lieu_naiss, prenom_pere, prenom_mere, nom_mere, email, whatsapp) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $nom_e, $prenom_e, $sexe, $date_n, $heure_n, $lieu_n, $p_pere, $p_mere, $n_mere, $email, $whatsapp]);

    echo "<script>alert('Enregistré ! ID Unique : $id'); window.location='recherche.php?id=$id';</script>";
}

// --- CAS 2 : RECHERCHE ET ENVOI (Génération PDF) ---
if (isset($_POST['rechercher_envoi'])) {
    $id_recherche = $_POST['id_unique'];
    $canal = $_POST['canal']; // 'whatsapp' ou 'email'

    $stmt = $pdo->prepare("SELECT * FROM citoyens WHERE id_citoyen = ?");
    $stmt->execute([$id_recherche]);
    $c = $stmt->fetch();

    if ($c) {
        // Génération du PDF avec cadres officiels
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Text(10, 15, "REGION DE DAKAR / VILLE DE DAKAR");
        $pdf->Text(130, 15, utf8_decode("RÉPUBLIQUE DU SÉNÉGAL"));
        
        $pdf->Rect(10, 50, 190, 110); // Cadre de l'acte
        $pdf->SetXY(15, 60);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(180, 10, "EXTRAIT D'ACTE DE NAISSANCE", 0, 1, 'C');
        
        $pdf->SetFont('Arial', '', 11);
        $pdf->Ln(5);
        $pdf->MultiCell(170, 8, utf8_decode("Identifiant : " . $c['id_citoyen'] . "\nNom : " . $c['nom'] . "\nPrénom : " . $c['prenom'] . "\nNé(e) le : " . $c['date_naiss'] . " à " . $c['lieu_naiss'] . "\nFils de : " . $c['prenom_pere'] . " " . $c['nom'] . "\nEt de : " . $c['prenom_mere'] . " " . $c['nom_mere']));

        // Sauvegarde physique
        if (!is_dir('extraits')) { mkdir('extraits', 0777, true); }
        $nom_pdf = "extraits/acte_" . $c['id_citoyen'] . ".pdf";
        $pdf->Output('F', $nom_pdf);

        $lien_doc = "http://localhost/mairie/" . $nom_pdf;
        $msg = "Bonjour, votre extrait est prêt : " . $lien_doc;

        // REDIRECTION SELON LE CANAL ET LA BASE DE DONNÉES
        if ($canal == 'whatsapp') {
            header("Location: https://api.whatsapp.com/send?phone=" . $c['whatsapp'] . "&text=" . urlencode($msg));
        } else {
            header("Location: mailto:" . $c['email'] . "?subject=Votre Extrait&body=" . urlencode($msg));
        }
        exit();
    } else {
        echo "<script>alert('ID Introuvable dans la base !'); window.history.back();</script>";
    }
}
?>