<?php
session_start();
include 'includes/db.php';

/* ===== CONFIG ADMIN ===== */
$admin_password = "admin123";

/* ===== CONNEXION ADMIN ===== */
if (isset($_POST['admin_login'])) {
    if ($_POST['admin_password'] === $admin_password) {
        $_SESSION['admin'] = true;
    }
}

/* ===== DÉCONNEXION ADMIN ===== */
if (isset($_POST['admin_logout'])) {
    unset($_SESSION['admin']);
}

/* ===== AJOUT COMMENTAIRE ===== */
if (
    !empty($_POST['nom']) &&
    !empty($_POST['message']) &&
    !isset($_POST['delete_id'])
) {
    $nom = htmlspecialchars($_POST['nom']);
    $message = htmlspecialchars($_POST['message']);

    $req = $pdo->prepare(
        "INSERT INTO commentaires (nom, message) VALUES (?, ?)"
    );
    $req->execute([$nom, $message]);
}

/* ===== SUPPRESSION COMMENTAIRE (ADMIN SEULEMENT) ===== */
if (isset($_POST['delete_id']) && isset($_SESSION['admin'])) {
    $id = (int) $_POST['delete_id'];

    $req = $pdo->prepare("DELETE FROM commentaires WHERE id = ?");
    $req->execute([$id]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commentaires</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<section class="page-commentaires">

    <h1>💬 Commentaires</h1>

    <!-- CONNEXION ADMIN -->
    <?php if (!isset($_SESSION['admin'])): ?>
        <form method="post" class="form-admin">
            <input type="password" name="admin_password" placeholder="Mot de passe admin">
            <button type="submit" name="admin_login" class="btn-small">
                Connexion admin
            </button>
        </form>
    <?php else: ?>
        <form method="post" class="form-admin">
            <button type="submit" name="admin_logout" class="btn-delete">
                Déconnexion admin
            </button>
        </form>
    <?php endif; ?>

    <!-- FORMULAIRE COMMENTAIRE -->
    <form method="post" class="form-commentaire">
        <input type="text" name="nom" placeholder="Votre nom" required>
        <textarea name="message" placeholder="Votre commentaire" required></textarea>
        <button type="submit" class="btn">Envoyer</button>
    </form>

    <!-- LISTE DES COMMENTAIRES -->
    <div class="liste-commentaires">
    <?php
    $req = $pdo->query("SELECT * FROM commentaires ORDER BY date_creation DESC");
    $commentaires = $req->fetchAll();

    if (count($commentaires) === 0) {
        echo '<p class="message-info">💬 Soyez le premier à laisser un commentaire.</p>';
    } else {
        foreach ($commentaires as $com) {
    ?>
        <div class="commentaire">
            <strong><?= $com['nom'] ?></strong>
            <span class="date">
                <?= date('d/m/Y H:i', strtotime($com['date_creation'])) ?>
            </span>

            <p><?= nl2br($com['message']) ?></p>

            <!-- BOUTON SUPPRIMER (ADMIN SEULEMENT) -->
            <?php if (isset($_SESSION['admin'])): ?>
                <form method="post" class="form-delete">
                    <input type="hidden" name="delete_id" value="<?= $com['id'] ?>">
                    <button type="submit" class="btn-delete">
                        Supprimer
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php
        }
    }
    ?>
    </div>

</section>

</body>
</html>
