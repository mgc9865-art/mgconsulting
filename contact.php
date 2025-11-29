<?php
// ----- CONFIG -----
$excelFile = "data_contacts.csv";   // Fichier Excel (CSV compatible Excel)
$sendMail  = false;                 // Mettez true si vous voulez envoyer un mail
$recipient = "votre-email@exemple.com"; // Email de réception si $sendMail = true
// --------------------

// Vérifier si le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sécurisation des entrées
    function clean($v) {
        return htmlspecialchars(trim($v), ENT_QUOTES, "UTF-8");
    }

    $name    = clean($_POST["name"] ?? "");
    $email   = clean($_POST["email"] ?? "");
    $phone   = clean($_POST["phone"] ?? "");
    $subject = clean($_POST["subject"] ?? "");
    $message = clean($_POST["message"] ?? "");

    // Vérification minimum
    if ($name === "" || $email === "" || $message === "") {
        die("Veuillez remplir au minimum Nom, Email et Message.");
    }

    // ----- SAUVEGARDE DANS FICHIER EXCEL (CSV) -----
    $newEntry = array(
        date("Y-m-d H:i:s"),  // Timestamp
        $name,
        $email,
        $phone,
        $subject,
        str_replace(array("\r", "\n"), " ", $message)  // enlever retours ligne
    );

    // Si fichier n’existe pas, créer l’en-tête
    if (!file_exists($excelFile)) {
        $header = array("Date", "Nom", "Email", "Téléphone", "Sujet", "Message");
        $fp = fopen($excelFile, "a");
        fputcsv($fp, $header, ";");
        fclose($fp);
    }

    // Ajouter la nouvelle ligne
    $fp = fopen($excelFile, "a");
    fputcsv($fp, $newEntry, ";");  // point-virgule = compatible Excel FR
    fclose($fp);

    // ----- ENVOI EMAIL (OPTIONNEL) -----
    if ($sendMail === true) {
        $mailContent = "Nouveau message du formulaire MG CONSEIL :\n\n".
                       "Nom : $name\n".
                       "Email : $email\n".
                       "Téléphone : $phone\n".
                       "Sujet : $subject\n".
                       "Message : $message\n";

        mail($recipient, "Nouveau contact MG Conseil", $mailContent);
    }

    // ----- MESSAGE DE CONFIRMATION -----
    echo "Merci ! Votre message a été envoyé et enregistré.";
    exit;
}
?>
