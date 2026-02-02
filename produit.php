<?php
require_once 'includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: boutique.php');
    exit;
}

$id = (int) $_GET['id'];

$req = $pdo->prepare("SELECT * FROM jeux WHERE id = ?");
$req->execute([$id]);
$jeu = $req->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Magasin de jeux</title>

    <!-- RESPONSIVE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php require_once 'includes/header.php'; ?>

<?php if (!$jeu): ?>

    <h1 style="text-align:center;">Produit introuvable</h1>

    <p class="message-erreur" style="text-align:center;">
        ❌ Ce produit n’existe pas ou a été supprimé.
    </p>

    <p style="text-align:center;">
        <a href="boutique.php" class="btn">Retour aux jouets</a>
    </p>

<?php else: ?>

<section class="page-produit">
    <div class="produit-container">

        <div class="produit-image">
            <img
                src="images/<?= htmlspecialchars($jeu['image'], ENT_QUOTES, 'UTF-8') ?>"
                alt="<?= htmlspecialchars($jeu['nom'], ENT_QUOTES, 'UTF-8') ?>"
            >
        </div>

        <div class="produit-info">
            <h1><?= htmlspecialchars($jeu['nom'], ENT_QUOTES, 'UTF-8') ?></h1>

            <p class="prix">
                <?= number_format((float)$jeu['prix'], 2, ',', ' ') ?> €
            </p>

            <p class="description">
                <?= nl2br(htmlspecialchars($jeu['description'], ENT_QUOTES, 'UTF-8')) ?>
            </p>

            <a href="boutique.php" class="btn">← Retour aux jouets</a>
        </div>

    </div>
</section>

<?php endif; ?>

</body>
</html>
