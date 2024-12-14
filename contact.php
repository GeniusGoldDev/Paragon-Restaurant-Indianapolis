<?php
$pageTitle = "Contact Us";
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize and validate form data
    $firstName = htmlspecialchars(trim($_POST["firstName"]));
    $lastName = htmlspecialchars(trim($_POST["lastName"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $comments = htmlspecialchars(trim($_POST["comments"]));

    $subject = "New Contact Form Submission";

    // Email message body
    $message = "First Name: " . $firstName . "\n";
    $message .= "Last Name: " . $lastName . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Comments/Complaints: " . $comments . "\n";

    // Mailtrap API Endpoint and Token
    $mailtrapEndpoint = 'https://sandbox.api.mailtrap.io/api/send/3342973';
    $mailtrapToken = 'be4ddd213b0ff17724d2baf124561b47';

    $payload = [
        'from' => [
            'email' => $email,
            'name' => 'Paragon Restaurant'
        ],
        'to' => [
            [
                'email' => 'gold005dev@gmail.com' // Replace with the recipient email address
            ]
        ],
        'subject' => $subject,
        'text' => $message,
        'category' => 'Contact Form Submission'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $mailtrapEndpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $mailtrapToken,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        echo "<div class='success-message' style='color:green; margin:auto'>Your message has been sent successfully.</div>";
    } else {
        echo "<div class='error-message' style='color:red;'>There was an error sending your message. Please try again later.</div>";
    }
}
?>
<div class="container">
    <div class="contact">
        <h1>Paragon Restaurant</h1>
        <p class="">Family Restaurant and Banquet Facility</p>
        <h2>Contact Information</h2>
        <p class="h_p1">S 118 S Girls School Rd<br>Indianapolis, IN 46231<br>(317) 271-3514</p>

        <h2>Comments / Complaints</h2>
        <h3>Leave Comments or Complaints for us using the form below.</h3>

        <div class="contacts">
            <form method="post">
                <div class="form-group">
                    <label for="firstName">First Name <span class="required">*</span></label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name <span class="required">*</span></label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="comments">Comments / Complaints <span class="required">*</span></label>
                    <textarea id="comments" name="comments" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
