<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commune Mermoz Sacré-Cœur - État Civil en Ligne</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        
        /* Header style fidèle à votre maquette et votre logo */
        header { background-color: #153a13; color: white; padding: 25px 0; text-align: center; }
        
        /* Intégration du logo de la mairie */
        header img.mairie-logo { 
            width: 130px; /* Ajusté pour la lisibilité sur fond bleu */
            height: auto;
            margin-bottom: 15px; 
            border-radius: 5px; /* Légère finition */
        }
        header h1 { margin: 0; font-size: 24px; font-weight: 600; }
        header p { margin: 5px 0 0; font-size: 16px; opacity: 0.9; }
        
        .container { max-width: 900px; margin: 40px auto; padding: 20px; text-align: center; }
        .welcome-text { margin-bottom: 40px; }
        .welcome-text h2 { color: #333; }
        
        /* Grille des services */
        .services-grid { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; }
        .card { 
            background: white; border-radius: 12px; padding: 30px; width: 350px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s;
            box-sizing: border-box; /* Important pour le padding */
        }
        
        

.service-card.blue:hover {
    border-color: #3b82f6;
}

.service-card.green:hover {
    border-color: #10b981;
}

        .card:hover { transform: translateY(-5px); }
        .card i { font-size: 40px; margin-bottom: 20px; }
        .card.blue i { color: #1a42bb; }
        .card.green i { color: #008744; }
        
        .btn { 
            display: inline-block; padding: 12px 25px; border-radius: 6px; 
            text-decoration: none; font-weight: bold; margin-top: 20px; 
            cursor: pointer;
        }
        .btn-blue { background-color: #1a42bb; color: white; }
        .btn-blue:hover { background-color: #1638a1; }
        .btn-green { background-color: #008744; color: white; }
        .btn-green:hover { background-color: #006b36; }
        
        /* Zone informations importantes */
        .info-box { 
            background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px;
            margin-top: 40px; padding: 20px; text-align: left;
        }
        .info-box h4 { margin-top: 0; display: flex; align-items: center; gap: 10px; color: #1a42bb; }
        
        footer { margin-top: 50px; padding: 30px; background: #222; color: #ccc; text-align: center; font-size: 12px; }
    </style>
</head>
<body>

<header>
    <img src="logo_mairie.png" alt="Logo Commune Mermoz Sacré-Cœur" class="mairie-logo">
    <h1>Commune de Mermoz / Sacré-Cœur</h1>
    <p>Service d'État Civil en Ligne</p>
</header>

<div class="container">
    <div class="welcome-text">
        <h2>Bienvenue sur notre plateforme d'État Civil</h2>
        <p>Choisissez le service dont vous avez besoin. Nous vous accompagnons dans vos démarches administratives.</p>
    </div>

    <div class="services-grid">
        <div class="card blue">
            <i class="fas fa-file-invoice"></i>
            <h3>Demander mon extrait</h3>
            <p>Obtenez votre extrait de naissance ou celui d'un membre de votre famille. Document officiel délivré rapidement.</p>
            <a href="demande.php" class="btn btn-blue">Accéder au formulaire</a>
        </div>

        <div class="card green">
            <i class="fas fa-baby-carriage"></i>
            <h3>Déclarer une naissance</h3>
            <p>Enregistrez la naissance de votre enfant auprès de notre service d'État Civil. Procédure simple et rapide.</p>
            <a href="declaration.php" class="btn btn-green">Accéder au formulaire</a>
        </div>
    </div>

    <div class="info-box">
        <h4><i class="fas fa-info-circle"></i> Informations importantes</h4>
        <ul>
            <li>Vous devrez fournir une adresse email et un numéro WhatsApp pour recevoir votre document.</li>
            <li>Le document sera généré au format PDF et envoyé sur vos coordonnées.</li>
            <li>Assurez-vous que toutes les informations saisies sont correctes avant de valider.</li>
        </ul>
    </div>
</div>

<footer>
            &copy; 2026 Commune Mermoz Sacré-Cœur - Tous droits réservés
</footer>

</body>
</html>