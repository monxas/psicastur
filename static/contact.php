<?php
session_start();
$time_limit = 60;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $subject = trim($_POST["subject"]);
  $phone_number = trim($_POST["phone-number"]);
  $message = trim($_POST["message"]);
  $honeypot = trim($_POST["direccion"]);

  
  if (!empty($honeypot)) {
    http_response_code(400);
    echo "Invalid request.";
    exit;
  }

    // Check the time limit for spam
    $last_submit_time = isset($_SESSION["last_submit_time"]) ? $_SESSION["last_submit_time"] : 0;
    $num_submissions = isset($_SESSION["num_submissions"]) ? $_SESSION["num_submissions"] : 0;
    $current_time = time();
    if (($current_time - $last_submit_time) < $time_limit && $num_submissions >= 5) {
      // If the time limit has not passed and the number of submissions exceeds the limit, this is likely a spam submission
      http_response_code(429);
      echo "Too many submissions. Please try again later.";
      exit;
    }

  // Check if all required fields are filled out
  if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo "Please fill out all required fields.";
    exit;
  }

  // Validate email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Correo no válido";
    exit;
  }

  // Set email recipient and subject
  $to = "administracion@psicastur.com";
  $bcc = "ramonkawa@gmail.com";
  $email_subject = "Mensaje del formulario de contacto: $subject";

  // Construct email message
  $email_body = "<html>
    <head>
      <meta charset=\"UTF-8\">
      <title>$email_subject</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #f6f6f6;
        }
        .container {
          max-width: 600px;
          margin: 0 auto;
          padding: 20px;
          background-color: #fff;
          border-radius: 5px;
        }
        h1 {
          font-size: 28px;
          color: #333;
        }
        p {
          font-size: 16px;
          color: #333;
          line-height: 1.5;
        }
      </style>
    </head>
    <body>
      <div class=\"container\">
        <h1>$email_subject</h1>
        <p><strong>Nombre:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Teléfono:</strong> $phone_number</p>
        <p><strong>Mensaje:</strong></p>
        <p>$message</p>
      </div>
    </body>
  </html>";

  // Set headers for HTML email
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "Bcc: $bcc\r\n";
  $headers .= "Content-type: text/html\r\n";

  // Send email
  if (mail($to, $email_subject, $email_body, $headers)) {
    http_response_code(200);
    echo "Mensaje enviado!";
    exit;
  } else {
    http_response_code(500);
    echo "Ha ocurrido un error. Por favor, inténtelo de nuevo.";
    exit;
  }
// Update the last submit time and number of submissions
$_SESSION["last_submit_time"] = $current_time;
$_SESSION["num_submissions"] = $num_submissions + 1;
} else {
http_response_code(400);
echo "Invalid request.";
exit;
}
