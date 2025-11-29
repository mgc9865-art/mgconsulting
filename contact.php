<?php
// Sécurité basique : vérifier que le formulaire est soumis en POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupération des champs
    $name    = isset($_POST['name'])    ? trim($_POST['name'])    : '';
    $email   = isset($_POST['email'])   ? trim($_POST['email'])   : '';
    $phone   = isset($_POST['phone'])   ? trim($_POST['phone'])   : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Format d’une ligne dans toto.txt
    $contenu  = "=============================\n";
    $contenu .= "Nom : $name\n";
    $contenu .= "Email : $email\n";
    $contenu .= "Téléphone : $phone\n";
    $contenu .= "Sujet : $subject\n";
    $contenu .= "Message : $message\n";
    $contenu .= "Date : " . date("Y-m-d H:i:s") . "\n";
    $contenu .= "=============================\n\n";

    // Écriture dans toto.txt
    file_put_contents("toto.txt", $contenu, FILE_APPEND | LOCK_EX);

    // Message de confirmation
    echo "<h2>Merci ! Votre message a bien été enregistré.</h2>";
    echo "<a href='index.html'>Retour au site</a>";
}
?>
