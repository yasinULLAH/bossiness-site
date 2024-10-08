<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define your recipient email address
    $to = "yasin7070@gmail.com";
    $subject = "New Contact Form Submission";

    // Validate and sanitize input fields
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);

    // Array to hold errors
    $errors = [];

    // Basic validation
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If there are no errors, send the email
    if (empty($errors)) {
        $body = "Name: $name\n";
        $body .= "Email: $email\n\n";
        $body .= "Message:\n$message\n";

        $headers = "From: $email";

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            echo json_encode(["status" => "success", "message" => "Message sent successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to send the message. Please try again later."]);
        }
    } else {
        // Return validation errors
        echo json_encode(["status" => "error", "errors" => $errors]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
