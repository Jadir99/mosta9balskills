<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = htmlspecialchars($_POST['con_name'] ?? '');
    $email = htmlspecialchars($_POST['con_email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? 'No Subject');
    $message = htmlspecialchars($_POST['con_message'] ?? '');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.mosta9balskills.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'services@mosta9balskills.com';
        $mail->Password   = '@mosta9balskills.com123';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('services@mosta9balskills.com', 'Mosta9bal skills');
        $mail->addAddress('mohamad.jadir2018@gmail.com', 'Mosta9bal skills');
        $mail->addReplyTo('services@mosta9balskills.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Nouveau message de contact: " . $subject;
        $mail->Body    = "
            <h2>Nouveau message depuis le formulaire de contact</h2>
            <p><strong>Nom:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Sujet:</strong> {$subject}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";
        $mail->AltBody = "Nouveau message:\nNom: {$name}\nEmail: {$email}\nSujet: {$subject}\nMessage:\n{$message}";

        $mail->send();

        // Redirect back to a thank you page or display success
        header('Location: thankyou.html');
        exit;
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du message : {$mail->ErrorInfo}";
    }
} else {
    echo "Requête non valide.";
}
?>
