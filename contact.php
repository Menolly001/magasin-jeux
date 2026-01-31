<?php
$success = false;
$error = false;

if (!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['message'])) {

    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $to = "caroledavid@hotmail.fr";
    $subject = "📬 Nouveau message depuis le site Magasin Jeux";

    $body = "Nom : $nom\n";
    $body .= "Email : $email\n\n";
    $body .= "Message :\n$message";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";

    if (mail($to, $subject, $body, $headers)) {
        $success = true;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<section class="page-contact">

    <h1>📬 Contact</h1>

    <p class="intro-contact">
        Une question ? Un problème ? N’hésitez pas à nous écrire.
    </p>

    <?php if ($success): ?>
        <p class="message-success">
            ✅ Merci pour votre message, il a bien été envoyé.
        </p>
    <?php elseif ($error): ?>
        <p class="message-erreur">
            ❌ Une erreur est survenue. L’envoi de l’email a échoué.
        </p>
    <?php endif; ?>

    <form method="post" class="form-contact">
        <input type="text" name="nom" placeholder="Votre nom" required>
        <input type="email" name="email" placeholder="Votre email" required>
        <textarea name="message" placeholder="Votre message" required></textarea>
        <button type="submit" class="btn">Envoyer</button>
    </form>

</section>

</body>
</html>

