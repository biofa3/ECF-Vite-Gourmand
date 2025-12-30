<?php
require_once 'config/db.php';

$erreurs = [];
$succes = false;

// Si le formulaire est envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Nettoyage des données (faille XSS)
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $gsm = htmlspecialchars($_POST['gsm']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $password = $_POST['password'];

    // --- VALIDATION DU MOT DE PASSE (Critères Julie & José) ---
    $regex_mdp = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/';
    
    if (!preg_match($regex_mdp, $password)) {
        $erreurs[] = "Le mot de passe doit faire 10 caractères min. avec 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.";
    }

    // Vérifier si l'email existe déjà
    $verif = $db->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    $verif->execute([$email]);
    if ($verif->fetch()) {
        $erreurs[] = "Cet email est déjà utilisé.";
    }

    // Si pas d'erreurs, on insère
    if (empty($erreurs)) {
        // Hashage sécurisé du mot de passe
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $insert = $db->prepare("INSERT INTO utilisateurs (nom, prenom, email, gsm, adresse_postale, mot_de_passe, role) VALUES (?, ?, ?, ?, ?, ?, 'utilisateur')");
            $insert->execute([$nom, $prenom, $email, $gsm, $adresse, $password_hash]);
            
            // TODO: Appeler ici la fonction pour envoyer le mail automatique de bienvenue
            
            $succes = true;
        } catch (Exception $e) {
            $erreurs[] = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte - Vite & Gourmand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'views/partials/header.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Inscription</h2>

                        <?php if (!empty($erreurs)): ?>
                            <div class="alert alert-danger">
                                <?php foreach($erreurs as $e) echo $e . "<br>"; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($succes): ?>
                            <div class="alert alert-success text-center">
                                Inscription réussie ! Un mail de bienvenue vous a été envoyé.<br>
                                <a href="login.php" class="btn btn-sm btn-outline-success mt-2">Se connecter</a>
                            </div>
                        <?php else: ?>

                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" class="form-control" required value="<?= $nom ?? '' ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" name="prenom" class="form-control" required value="<?= $prenom ?? '' ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email (Username)</label>
                                <input type="email" name="email" class="form-control" required value="<?= $email ?? '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Numéro GSM</label>
                                <input type="text" name="gsm" class="form-control" required value="<?= $gsm ?? '' ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Adresse postale</label>
                                <textarea name="adresse" class="form-control" rows="2" required><?= $adresse ?? '' ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                                <small class="text-muted">Min. 10 caractères, 1 Maj, 1 Chiffre, 1 Spécial (@,$,!, etc.)</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Créer mon compte</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="text-center mt-3"><a href="login.php" class="text-decoration-none text-muted">Déjà client ? Se connecter</a></p>
            </div>
        </div>
    </div>

    <?php include 'views/partials/footer.php'; ?>
</body>
</html>