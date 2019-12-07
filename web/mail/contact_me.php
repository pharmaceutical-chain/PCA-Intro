<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer"s autoloader
require "../../vendor/autoload.php";

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
   //Server settings
   $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
   $mail->isSMTP();                                            // Send using SMTP
   $mail->Host       = "smtp.ethereal.email";                  // Set the SMTP server to send through
   $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
   $mail->Username   = "otis58@ethereal.email";                // SMTP username
   $mail->Password   = "V6PKchDW9U8D57r8gK";                   // SMTP password
   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
   $mail->Port       = 587;                                    // TCP port to connect to

   // Check for empty fields
   if(empty($_POST["name"])      ||
      empty($_POST["email"])     ||
      empty($_POST["phone"])     ||
      empty($_POST["message"])   ||
      !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
   {
      echo "No arguments Provided!";
      return false;
   }
   $name = strip_tags(htmlspecialchars($_POST["name"]));
   $email_address = strip_tags(htmlspecialchars($_POST["email"]));
   $phone = strip_tags(htmlspecialchars($_POST["phone"]));
   $message = strip_tags(htmlspecialchars($_POST["message"]));

   //Recipients
   $mail->setFrom($email_address, $name);
   $mail->addAddress("otis58@ethereal.email", "Admin");     // Add a recipient
   // $mail->addReplyTo("info@example.com", "Information");
   // $mail->addCC("cc@example.com");
   // $mail->addBCC("bcc@example.com");

   // Attachments
   // $mail->addAttachment("/var/tmp/file.tar.gz");         // Add attachments
   // $mail->addAttachment("/tmp/image.jpg", "new.jpg");    // Optional name

   // Content
   $mail->isHTML(true);                                     // Set email format to HTML
   $mail->Subject = "Introduction Platform - $name";
   $mail->Body    = "<div style='font-family: Montserrat,-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto;color: rgba(51, 51, 51, 0.87);'>"
                  . "<h3>You have received a new message from <b style='text-transform: uppercase;'>Introduction Platform Contact Form</b></h3>"
                  . "\n"
                  . "<p>Name: <b>$name</b></p>"
                  . "<p>Email: <b>$email_address</b></p>"
                  . "<p>Phone: <b>$phone</b></p>"
                  . "<p>Message: <b>$message</b></p>"
                  . '</div>';
   $mail->AltBody = "You have received a new message from Introduction Platform Contact Form.\n\n"."\nName: $name\nEmail: $email_address\nPhone: $phone\nMessage: $message";

   $mail->send();
   echo "Message has been sent";
   return true;
} catch (Exception $e) {
   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   return false;
}