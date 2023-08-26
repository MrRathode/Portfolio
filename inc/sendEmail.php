<?php

$siteOwnersEmail = 'mrrathode111@gmail.com';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['contactName']);
    $email = trim($_POST['contactEmail']);
    $subject = trim($_POST['contactSubject']);
    $contact_message = trim($_POST['contactMessage']);

    $errors = [];
    if (empty($name)) {
        $errors['name'] = "Please enter your name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }
    if (empty($subject)) {
        $subject = "Contact Form Submission";
    }
    if (strlen($contact_message) < 15) {
        $errors['message'] = "Please enter your message. It should have at least 15 characters.";
    }

    if (empty($errors)) {
        $message = "Email from: " . $name . "<br />";
        $message .= "Email address: " . $email . "<br />";
        $message .= "Message: <br />";
        $message .= $contact_message;
        $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $mailSent = mail($siteOwnersEmail, $subject, $message, $headers);

        if ($mailSent) {
            echo "OK"; // Sent successfully
        } else  {
            echo "Something went wrong. Please try again."; // Failed to send
        }
    } else {
        $errorMessages = implode('<br>', $errors);
        echo $errorMessages;
    }
}

?>
