<?php
// On inclut la config pour la base de données
require_once 'config/db.php';

// TODO   : Penser à vérifier la session ici si besoin plus tard
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vite & Gourmand | Traiteur Bordeaux</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include 'views/partials/header.php'; ?>

    <header class="bg-light py-5">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        <h1 class="display-5 fw-bolder text-dark mb-2">Vite & Gourmand</h1>
                        <p class="lead fw-normal text-muted mb-4">Julie et José, votre traiteur de confiance à Bordeaux depuis 25 ans. Des menus qui changent selon les saisons !</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            <a class="btn btn-primary btn-lg px-4 me-sm-3" href="menus.php">Voir la carte</a>
                            <a class="btn btn-outline-dark btn-lg px-4" href="contact.php">Nous contacter</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                    <img class="img-fluid rounded-3 my-5" src="assets/img/accueil_image.jpg" alt="Plat gourmand" />
                </div>
            </div>
        </div>
    </header>

    <section class="py-5" id="presentation">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">Notre savoir-faire bordelais.</h2></div>
                <div class="col-lg-8">
                    <p class="lead fw-normal text-muted mb-0">Julie s'occupe de la partie client et José est aux fourneaux. Ensemble, ils créent des menus uniques pour Noël, Pâques ou vos repas de tous les jours. Le professionnalisme et la qualité sont nos priorités depuis 25 ans.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">Ce que disent nos clients</h2>
            </div>
            <div class="row gx-5">
                <?php
                // Simulation de récupération des avis en BDD
                // $sql = "SELECT * FROM avis WHERE est_valide = 1 LIMIT 3";
                // $stmt = $db->query($sql);
                // while($row = $stmt->fetch()) :
                ?>
                <div class="col-lg-4">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">
                            <div class="text-warning mb-3">⭐⭐⭐⭐⭐</div>
                            <p class="card-text mb-0">"Super repas pour Noël, les produits étaient frais et la livraison pile à l'heure !"</p>
                            <div class="mt-3 small text-muted">- Client satisfait</div>
                        </div>
                    </div>
                </div>
                <?php // endwhile; ?>
            </div>
        </div>
    </section>

    <?php include 'views/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>