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
    echo "Correo no válido";
    exit;
  }

  // Set email recipient and subject
  $to = "ramonkawa@gmail.com";
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
} else {
  http_response_code(400);
  echo "Invalid request.";
  exit;
}
