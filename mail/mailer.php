<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

?>

<?php

function responseEmail($name,$email,$phone,$message)
    {

        if(filter_var($email,FILTER_VALIDATE_EMAIL)===false)
        {
            echo "<script>alert('Please enter a valid email address')</script>";
        }
        else
        {
            $mail=new PHPMailer(true); 

            try {
                //Server settings
                $mail->isSMTP();                                  //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';             //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                         //Enable SMTP authentication
                $mail->Username   = 'demoooacc06@gmail.com';      //SMTP username
                $mail->Password   = 'ngcf rlix aeoc snej';        //SMTP password
                $mail->SMTPSecure = 'tls';                        //Enable implicit TLS encryption
                $mail->Port       = 587;                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                $mail->setFrom('demoooacc06@gmail.com');
                $mail->addAddress($email);
                $mail->addAddress('demoooacc06@gmail.com');
                $mailTemplate="
                <html>
                    <head>
                    <title>Greetings Email</title>
                    </head>
                    <body>
                        <p style='font-size: 18px; color: #333; font-family: Arial, sans-serif;'>Responded by the creator of Bid2Buy.</p>
                        <p style='font-size: 16px; color: #666; font-family: Arial, sans-serif;'>Hope you are doing well!</p>
                        <p style='font-size: 16px; color: #666; font-family: Arial, sans-serif;'>'Your response is,<br>'.$message.'</p>
                    </body>
                </html>
                "; 

                // Set the subject with HTML styling
                $mail->Subject = "Response Email";

                $mail->Body=$mailTemplate;
                $mail->isHTML(true);

                $mail->send();

                die("die vayo");
            }
            catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }


$sent=false;

if(isset($_POST['Submit']) && ($_SERVER["REQUEST_METHOD"]=="POST"))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $message=$_POST['message'];
    if($message)
    {
        function responseEmail($name,$email,$phone,$message)
    }
    {

        if(filter_var($email,FILTER_VALIDATE_EMAIL)===false)
        {
            echo "<script>alert('Please enter a valid email address')</script>";
        }
        else
        {
            $mail=new PHPMailer(true); 

            try {
                //Server settings
                $mail->isSMTP();                                  //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';             //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                         //Enable SMTP authentication
                $mail->Username   = 'demoooacc06@gmail.com';      //SMTP username
                $mail->Password   = 'ngcf rlix aeoc snej';        //SMTP password
                $mail->SMTPSecure = 'tls';                        //Enable implicit TLS encryption
                $mail->Port       = 587;                          //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                $mail->setFrom('demoooacc06@gmail.com');
                $mail->addAddress($email);
                $mail->addAddress('demoooacc06@gmail.com');
                $mailTemplate="
                <html>
                    <head>
                    <title>Greetings Email</title>
                    </head>
                    <body>
                        <p style='font-size: 18px; color: #333; font-family: Arial, sans-serif;'>Responded by the creator of Bid2Buy.</p>
                        <p style='font-size: 16px; color: #666; font-family: Arial, sans-serif;'>Hope you are doing well!</p>
                        <p style='font-size: 16px; color: #666; font-family: Arial, sans-serif;'>'Your response is,<br>'.$message.'</p>
                    </body>
                </html>
                "; 

                // Set the subject with HTML styling
                $mail->Subject = "Response Email";

                $mail->Body=$mailTemplate;
                $mail->isHTML(true);

                $mail->send();

                die("die vayo");
            }
            catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}

?>