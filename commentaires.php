
<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/config.php';

/* ===== CONFIG ADMIN ===== */
$admin_password_hash = ADMIN_PASSWORD_HASH;

/* ===== CONNEXION ADMIN ===== */
if (isset($_POST['admin_login'], $_POST['admin_password'])) {
    if (password_verify($_POST['admin_password'], $admin_password_hash)) {
        $_SESSION['admin'] = true;
        session_regenerate_id(true);
    } else {
        $error_admin = "Mot de passe incorrect";
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
    $nom = trim($_POST['nom']);
    $message = trim($_POST['message']);

    $req = $pdo->prepare(
        "INSERT INTO commentaires (nom, message) VALUES (?, ?)"
    );
    $req->execute([$nom, $message]);
}

/* ===== SUPPRESSION COMMENTAIRE (ADMIN SEULEMENT) ===== */
if (
    isset($_POST['delete_id']) &&
    isset($_SESSION['admin']) &&
    $_SESSION['admin'] === true
) {
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

    <!-- RESPONSIVE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php require_once 'includes/header.php'; ?>

<section class="page-commentaires">

    <h1>💬 Commentaires</h1>

    <!-- CONNEXION ADMIN -->
    <?php if (!isset($_SESSION['admin'])): ?>
        <form method="post" class="form-admin">
            <input
                type="password"
                name="admin_password"
                placeholder="Mot de passe admin"
                required
            >
            <button type="submit" name="admin_login" class="btn-small">
                Connexion admin
            </button>

            <?php if (!empty($error_admin)): ?>
                <p class="message-error">
                    <?= htmlspecialchars($error_admin, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>
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
        <input
            type="text"
            name="nom"
            placeholder="Votre nom"
            required
        >
        <textarea
            name="message"
            placeholder="Votre commentaire"
            required
        ></textarea>
        <button type="submit" class="btn">
            Envoyer
        </button>
    </form>

    <!-- LISTE DES COMMENTAIRES -->
    <div class="liste-commentaires">
    <?php
    $req = $pdo->query(
        "SELECT * FROM commentaires ORDER BY date_creation DESC"
    );
    $commentaires = $req->fetchAll(PDO::FETCH_ASSOC);

    if (count($commentaires) === 0):
    ?>
        <p class="message-info">
            💬 Soyez le premier à laisser un commentaire.
        </p>
    <?php
    else:
        foreach ($commentaires as $com):
    ?>
        <div class="commentaire">
            <strong>
                <?= htmlspecialchars($com['nom'], ENT_QUOTES, 'UTF-8') ?>
            </strong>

            <span class="date">
                <?= date('d/m/Y H:i', strtotime($com['date_creation'])) ?>
            </span>

            <p>
                <?= nl2br(htmlspecialchars($com['message'], ENT_QUOTES, 'UTF-8')) ?>
            </p>

            <!-- SUPPRESSION (ADMIN SEULEMENT) -->
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] === true): ?>
                <form method="post" class="form-delete">
                    <input
                        type="hidden"
                        name="delete_id"
                        value="<?= (int)$com['id'] ?>"
                    >
                    <button type="submit" class="btn-delete">
                        Supprimer
                    </button>
                </form>
            <?php endif; ?>
        </div>
    <?php
        endforeach;
    endif;
    ?>
    </div>

</section>

</body>
</html>

