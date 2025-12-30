<?php
session_start();
require_once '../config/db.php';
// Vérification du rôle employé ici...
require_once '../views/partials/header.php';

$commandes = $db->query("SELECT c.*, u.nom, m.titre FROM commande c JOIN utilisateur u ON c.utilisateur_id = u.utilisateur_id JOIN menu m ON c.menu_id = m.menu_id WHERE c.statut != 'Annulée' ORDER BY c.date_commande DESC")->fetchAll();
?>

<main class="container py-5">
    <h2>Gestion des Commandes (Julie & José)</h2>
    <div class="row mt-4">
        <?php foreach($commandes as $c): ?>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-<?= $c['statut'] == 'En attente' ? 'warning' : 'success' ?>">
                <div class="card-body">
                    <h6>Client : <?= htmlspecialchars($c['nom']) ?></h6>
                    <p class="small">Menu : <?= htmlspecialchars($c['titre']) ?> (x<?= $c['nombre_personne'] ?>)</p>
                    <form action="update_commande.php" method="POST">
                        <input type="hidden" name="id" value="<?= $c['numero_commande'] ?>">
                        <select name="statut" class="form-select form-select-sm mb-2">
                            <option value="Accepté" <?= $c['statut'] == 'Accepté' ? 'selected' : '' ?>>Accepté</option>
                            <option value="En préparation" <?= $c['statut'] == 'En préparation' ? 'selected' : '' ?>>En préparation</option>
                            <option value="Livré" <?= $c['statut'] == 'Livré' ? 'selected' : '' ?>>Livré</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm w-100">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>