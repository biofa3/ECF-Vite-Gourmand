<?php
session_start();
require_once '../config/db.php';

// Sécurité : Seuls les employés/admin peuvent accéder à cette page
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] === 'client') {
    header('Location: login.php');
    exit();
}

// Logique de modération (Action lors du clic sur un bouton)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $nouveau_statut = ($_GET['action'] === 'approuver') ? 'publié' : 'refusé';

    $stmt = $db->prepare("UPDATE avis SET statut = ? WHERE avis_id = ?");
    $stmt->execute([$nouveau_statut, $id]);
    $message = "L'avis a été mis à jour avec succès.";
}

// Récupération des avis en attente de modération
$query = $db->query("SELECT a.*, u.nom, m.titre as menu_nom 
                     FROM avis a 
                     JOIN utilisateur u ON a.utilisateur_id = u.utilisateur_id 
                     JOIN menu m ON a.menu_id = m.menu_id 
                     WHERE a.statut = 'en_attente' 
                     ORDER BY a.date_avis DESC");
$avis_en_attente = $query->fetchAll();

require_once '../views/partials/header.php';
?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modération des avis</h1>
        <span class="badge bg-warning text-dark"><?= count($avis_en_attente) ?> en attente</span>
    </div>

    <?php if (isset($message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (empty($avis_en_attente)): ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <p class="lead text-muted">Tous les avis ont été modérés !</p>
            </div>
        <?php else: ?>
            <?php foreach ($avis_en_attente as $avis): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light d-flex justify-content-between">
                            <strong><?= htmlspecialchars($avis['nom']) ?></strong>
                            <small class="text-muted">Le <?= date('d/m/Y', strtotime($avis['date_avis'])) ?></small>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Menu :</strong> <?= htmlspecialchars($avis['menu_nom']) ?></p>
                            <div class="text-warning mb-2">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i class="<?= $i <= $avis['note'] ? 'fas' : 'far' ?> fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="card-text">"<?= htmlspecialchars($avis['commentaire']) ?>"</p>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex gap-2">
                            <a href="moderer_avis.php?action=approuver&id=<?= $avis['avis_id'] ?>" 
                               class="btn btn-success btn-sm w-100">
                               <i class="fas fa-check me-1"></i> Publier
                            </a>
                            <a href="moderer_avis.php?action=refuser&id=<?= $avis['avis_id'] ?>" 
                               class="btn btn-outline-danger btn-sm w-100" 
                               onclick="return confirm('Refuser cet avis ?')">
                               <i class="fas fa-times me-1"></i> Refuser
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php require_once '../views/partials/footer.php'; ?>