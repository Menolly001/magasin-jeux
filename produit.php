<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: boutique.php');
    exit;
}

$id = (int) $_GET['id'];

$req = $pdo->prepare("SELECT * FROM jeux WHERE id = ?");
$req->execute([$id]);
$jeu = $req->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produit</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<?php if (!$jeu): ?>

    <p class="message-erreur">
        ❌ Ce produit n’existe pas ou a été supprimé.
    </p>

    <p style="text-align:center;">
        <a href="boutique.php" class="btn">Retour aux jouets</a>
    </p>

<?php else: ?>

<section class="page-produit">
    <div class="produit-container">

        <div class="produit-image">
            <img src="images/<?= $jeu['image'] ?>" alt="<?= $jeu['nom'] ?>">
        </div>

        <div class="produit-info">
            <h1><?= $jeu['nom'] ?></h1>
            <p class="prix"><?= $jeu['prix'] ?> €</p>

            <p class="description">
                <?= nl2br($jeu['description']) ?>
            </p>

            <a href="boutique.php" class="btn">← Retour aux jouets</a>
        </div>

    </div>
</section>

<?php endif; ?>

</body>
</html>

