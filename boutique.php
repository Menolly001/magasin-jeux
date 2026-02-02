<?php
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos jouets</title>

    <!-- RESPONSIVE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include 'includes/header.php'; ?>

<section class="page-boutique">
    <h1 class="titre-page">🧸 Nos jouets</h1>

    <div class="jeux">
    <?php
    $req = $pdo->query("SELECT * FROM jeux");
    $jeux = $req->fetchAll();

    if (count($jeux) === 0) {
        echo '<p class="message-info">🧸 Aucun jouet n’est disponible pour le moment.</p>';
    } else {
        foreach ($jeux as $jeu) {
    ?>
        <div class="carte">
            <div class="img-produit">
                <img src="images/<?= $jeu['image'] ?>" alt="<?= $jeu['nom'] ?>">
            </div>

            <div class="info-produit">
                <h3><?= $jeu['nom'] ?></h3>
                <p class="prix"><?= $jeu['prix'] ?> €</p>
                <a href="produit.php?id=<?= $jeu['id'] ?>" class="btn btn-small">
                    Voir le produit
                </a>
            </div>
        </div>
    <?php
        }
    }
    ?>
    </div>
</section>

</body>
</html>
