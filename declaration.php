<?php
require('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et formatage
    $id = "REG-" . time(); // Génération d'un ID unique basé sur le temps
    $nom = strtoupper($_POST['nom_enfant']);
    $prenom = strtoupper($_POST['prenom_enfant']);
    $sexe = $_POST['sexe'] ?? 'M'; // Par défaut masculin si non spécifié
    $date_naiss = $_POST['date_naiss'];
    $lieu_naiss = strtoupper($_POST['lieu_naiss']);
    $prenom_pere = strtoupper($_POST['prenom_pere']);
    $prenom_mere = strtoupper($_POST['prenom_mere']);
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];

    // Insertion SQL
    $sql = "INSERT INTO citoyens (id_citoyen, nom, prenom, sexe, date_naiss, lieu_naiss, nom_pere, nom_mere, email, whatsapp) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $id, $nom, $prenom, $sexe, $date_naiss, $lieu_naiss, $prenom_pere, $prenom_mere, $email, $whatsapp
    ]);

    echo "<script>alert('Citoyen enregistré ! ID Unique : $id'); window.location='demande.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déclaration de Naissance</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7f6; margin: 0; }
        header { background: #1a42bb; color: white; padding: 20px; text-align: center; }
        .container { max-width: 700px; margin: 20px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .form-header { background: #e6f4ea; color: #1e7e34; padding: 15px; font-weight: bold; border-radius: 4px; margin-bottom: 20px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #008744; color: white; border: none; padding: 15px; width: 100%; border-radius: 4px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

<header>
    <h1>Mairie de Sacré-Cœur</h1>
</header>

<div class="container">
    <div class="form-header">Déclaration de Naissance</div>
    <form method="POST">
        <label>Nom de l'enfant *</label>
        <input type="text" name="nom_enfant" required>
        
        <label>Prénom(s) de l'enfant *</label>
        <input type="text" name="prenom_enfant" required>
        
        <label>Date de naissance *</label>
        <input type="date" name="date_naiss" required>
        
        <label>Lieu de naissance *</label>
        <input type="text" name="lieu_naiss" required>
        <label>Prénom du père *</label>
        <input type="text" name="prenom_pere" required>
        <label>Prénom de la mère *</label>
        <input type="text" name="prenom_mere" required>
        <label>Hopital *</label>
        <input type="text" name="nom_mere" required>
        <label>Email *</label>
        <input type="email" name="email" placeholder="exemple@domaine.com" required>
        <label>Numéro WhatsApp *</label>
        <input type="text" name="whatsapp" placeholder="221770000000" required>

        <button type="submit">Enregistrer </button>
    </form>
</div>

</body>
</html>