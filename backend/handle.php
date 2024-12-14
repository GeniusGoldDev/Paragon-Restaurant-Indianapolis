<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // For simplicity, write data to a file
    $data = "Name: $name\nEmail: $email\nMessage: $message\n\n";
    file_put_contents('../messages.txt', $data, FILE_APPEND);

    echo "Thank you, $name! Your message has been received.";
    echo "<br><a href='../contact.php'>Go Back</a>";
} else {
    header("Location: ../contact.php");
    exit;
}
