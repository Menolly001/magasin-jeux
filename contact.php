<?php
$success = false;
$error = false;

if (
    isset($_POST['nom'], $_POST['email'], $_POST['message']) &&
    !empty($_POST['nom']) &&
    !empty($_POST['email']) &&
    !empty($_POST['message'])
) {
    // Nettoyage et sécurisation
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validation email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $nom_safe = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
        $email_safe = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $message_safe = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $to = "caroledavid@hotmail.fr";
        $subject = "📬 Nouveau message depuis le site Magasin Jeux";

        $body  = "Nom : $nom_safe\n";
        $body .= "Email : $email_safe\n\n";
        $body .= "Message :\n$message_safe";

        $headers  = "From: Magasin Jeux <no-reply@magasin-jeux.local>\r\n";
        $headers .= "Reply-To: $email_safe\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8";

        if (mail($to, $subject, $body, $headers)) {
            $success = true;
        } else {
            $error = true;
        }

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

    <!-- RESPONSIVE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php require_once 'includes/header.php'; ?>

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
            ❌ Une erreur est survenue. Veuillez vérifier les champs et réessayer.
        </p>
    <?php endif; ?>

    <form method="post" class="form-contact">
        <input
            type="text"
            name="nom"
            placeholder="Votre nom"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="Votre email"
            required
        >

        <textarea
            name="message"
            placeholder="Votre message"
            required
        ></textarea>

        <button type="submit" class="btn">
            Envoyer
        </button>
    </form>

</section>

</body>
</html>
