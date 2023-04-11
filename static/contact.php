<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $subject = trim($_POST["subject"]);
  $phone_number = trim($_POST["phone-number"]);
  $message = trim($_POST["message"]);

  // Check if all required fields are filled out
  if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo "Please fill out all required fields.";
    exit;
  }

  // Validate email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Invalid email address.";
    exit;
  }

  // Set email recipient and subject
  $to = "ramonkawa@gmail.com";
  $email_subject = "Mensaje del formulario de contacto: $subject";

  // Construct email message
  $email_body = "Name: $name\n\nEmail: $email\n\nPhone Number: $phone_number\n\nMessage:\n$message";

  // Send email
  if (mail($to, $email_subject, $email_body)) {
    http_response_code(200);
    echo "Message sent successfully.";
    exit;
  } else {
    http_response_code(500);
    echo "An error occurred while sending the message. Please try again later.";
    exit;
  }
} else {
  http_response_code(400);
  echo "Invalid request.";
  exit;
}
