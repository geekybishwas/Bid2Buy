<?php 

session_start();

require_once "../required/database.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mail/PHPMailer/src/Exception.php';
require '../mail/PHPMailer/src/PHPMailer.php';
require '../mail/PHPMailer/src/SMTP.php';


$otp=mt_rand(10000,999999);


$sent=false;

//MAIL VERIFICATION

function emailVerification($email,$otp)
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

            //Recipients
            $mail->setFrom('demoooacc06@gmail.com');
            $mail->addAddress($email);
            $mail->addAddress('demoooacc06@gmail.com');
            $mailTemplate="

            <p>Verify your email address through OTP</p>
            <p>Your OTP is" .$otp. ".Enter the provided otp</p>"; 

            $mail->Subject="Email verification form Bid2Buy";
            $mail->Body=$mailTemplate;
            $mail->isHTML(true);

            $mail->send();
            $sent=true;
            return $sent;


        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $sent=false;
            return $sent;
        }
        
}

//Checking provided email exist or not in database
function emailExist($conn,$email)
{
    if(filter_var($email,FILTER_VALIDATE_EMAIL)===false)
    {
        echo "<script>Please enter a valid email</script>";
    }
    else
    {
        $sql="SELECT *FROM Customer WHERE email='$email'";
        $stmt=mysqli_query($conn,$sql);
        $user=mysqli_fetch_assoc($stmt);
        // die("sab thik xa");
        return true;
        // return $user;    
    }
}

//Checking provided name is exist or not in database
function nameExist($conn,$name)
{
    $sql="SELECT *FROM Customer WHERE name='$name'";
    $stmt=mysqli_query($conn,$sql);
    $user=mysqli_fetch_assoc($stmt);
    return $user;
}


//Only for the password Retrival email form
if(isset($_POST['send']) && $_SERVER["REQUEST_METHOD"]=="POST")
{
    $email=$_POST['email'];

    // echo $email;

    if(emailExist($conn,$email))
    {
        $emailSentOrNot=emailVerification($email,$otp);

        // $emailSentOrNot=true;
        // die("email send vayo");

        if($emailSentOrNot)
        {
            // die("email ma die va");
            echo "<script>alert('Otp sent succesfully to your email address')</script>";
            // header("Location: doRegistration.php");
        }
    }

}

//REGISTER FORM BACKEND

if(isset($_POST["Register"]) && ($_SERVER["REQUEST_METHOD"]=="POST") && isset($_POST["accountType"]))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contactNumber=$_POST['phnNumber'];
    $password=$_POST['password'];
    $confirmPassword=$_POST['rPassword'];
    // $country=$_POST['country'];
    $accountType=$_POST['accountType'];

    //Checking user already exist or not
    if(emailExist($conn,$email))
    {
        echo "<script>alert('Email already exist')</script>";
        header("Location: ../register.php");
    }
    elseif(nameExist($conn,$name))
    { 
        echo "<script>alert('Email already exist')</script>";
        header("Location: ../register.php");
    }
    else
    {
        if(strcmp($password,$confirmPassword))
        {
            echo "<script>alert('Password must match')</script>";
        }
        else
        {
                $emailSentOrNot=emailVerification($email,$otp);

        }
    }
}

// For OTP Verification and inserting the registered data into database.

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Verifyy"])) 
{
    $receivedOtp = $_POST["otp"];
    echo $receivedOtp;
    // die("adfasdf");
    if($emailSentOrNot)
    {
        if($otp==$receivedOtp)
        {
            //If OTP is verified,proceed with registration
            $passwordHash=password_hash($password,PASSWORD_DEFAULT);

            //Creating sql query
            $sql="INSERT INTO Customer (name,email,contactNumber,passwordHash,country,accountType) VALUES(?,?,?,?,?,?)";

            //Prepare it for execution for prepare function
            $stmt = mysqli_prepare($conn, $sql);


            //Checking
            if (!$stmt) 
            {
                die("Error in prepared statement: " . mysqli_error($conn));
            }
            else
            {
                //Binding
                mysqli_stmt_bind_param($stmt, "ssisss", $name,$email,$contactNumber,$passwordHash,$country,$accountType);

                //Exevute the prepared statement using execute function ,we call this function when database serverr inserts the values into sql .If this execute function returns true,then it works
                                
                $result=mysqli_stmt_execute($stmt);

                if($result)
                {

                //Making sql statement to get the customer id from database
                $sql="SELECT *FROM Customer where email='$email'";
                                    
                $stmt=mysqli_query($conn,$sql);
                                    
                $user=mysqli_fetch_assoc($stmt);

                //Set session varibles
                $_SESSION['customerId']=$user['customerId'];

                header("Location: ../html/signin.php");

                }
                else
                {

                    echo "<script>Verification succesfully</script>";
                }

            }

        }
    }
    else
    {
        echo "<scri>Email not sent</script>";
    }

}


            //PHP CODE FOR UPDATING THE PASSWORD AFTER FORGOTEN 
if(isset($_POST['forgetPassword']))
{
    $password=$_POST['forgetPassword'];
    $passwordHash=password_hash($password,PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement to update the password
    $sql = "UPDATE Customer SET passwordHash = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $email);

    if (mysqli_stmt_execute($stmt))
        {
            echo "<script>alert('Password Changed Successfully');</script>";
            header("Location: ../html/signin.php"); // Redirect to the login page
        }
}

?>
            <!-- ENDING PHP CODE FOR UPDATING THE PASSWORD AFTER FORGOTEN -->
            


                                    <!-- HTML PAGE -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .hidden{
        display: none;
    }
    </style>
</head>
<body>

                        <!-- JS CODE FOR OTP FORM AND PASSWORD RETRIVAL FORM  -->
        <script>

        document.addEventListener('DOMContentLoaded', function() {
                                // FOR OTPFORM
            document.getElementById('otpForm').addEventListener('submit', function(event) {
                // event.preventDefault(); // Prevent form submission
                
                                // Show the retrievePasswordForm and hide the otpForm
                document.getElementById('otpForm').classList.add('hidden');
                document.getElementById('retrievePassword').classList.remove('hidden');
            });

            document.getElementById('retrievePassword').addEventListener('submit', function(event) {
                // event.preventDefault(); // Prevent form submission
                
                                // Hide the retrievePassword Form after entering password and lead it to php file with the help of ajax
                document.getElementById('retrievePassword').classList.add('hidden');
                

                var password=document.getElementById('password').value;

                var rpassword=document.getElementById("rPassword").value;

                //Returns 0 if string is equal , negative if password comes before rPassword,positive if password comes after rPassword
                var comparePassword=password.localeCompare(rPassword);  

                // PASSWORD MATCH SUCCESSFULLY
                if(comparePassword==0)
                {
                    
                                //AJAX FOR PASSWORD RETRIVAL
                    const xhr = new XMLHttpRequest();

                    xhr.onload = function () {
                        // Handle response here
                        console.log(xhr.responseText);
                    };

                    xhr.open("POST", "doRegistration.php", true);

                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    
                    xhr.send("forgetPassword=" + encodeURIComponent(password));

                }
                else
                {
                    alert("Password must match");
                }
            });
        });

        </script>
                            <!-- ENDING JS CODE FOR OTP FORM AND PASSWORD RETRIVAL FORM  -->


                                        <!-- OTPFORM FOR THE RETRIVAL OF PASSWORD-->

<form method="POST" id="otpForm">
    <div>
        <input type="text" maxlength="1" />
        <input type="text" maxlength="1" disabled />
        <input type="text" maxlength="1" disabled />
        <input type="text" maxlength="1" disabled />
        <input type="text" maxlength="1" disabled />
        <input type="text" maxlength="1" disabled />
    </div>
    <input type="submit" name="Verify" value="Verify">
</form>

                            <!-- Password Form after retrival password -->

<form method="POST" id="retrievePassword" class="hidden">

    Password
    <input type="password" name="password" id="password">

    Confirm Password

    <input type="rPassword" name="rPassword" id="rPassword">

    <input type="submit" name="Submit" value="Submit">

</form>
                                        <!-- JS CODE FOR OTP -->
        
        <script>

                                        // Retrieving entered otp
        var inputFields = document.querySelectorAll("input");
        document.addEventListener("DOMContentLoaded", function () {
                inputFields.forEach(function (input, index) {
                    input.addEventListener("keyup", function () {
                        if (input.value.length > 0) {
                            if (index <inputFields.length - 1) {
                                console.log(index);
                                inputFields[index + 1].removeAttribute(
                                    "disabled"
                                );
                                inputFields[index + 1].focus();
                            }
                        }
                    });
                });
        });

                                    //Ajax for passing entered otp to PHP after submit the otpForm
        const form = document.querySelector("form");
        form.addEventListener("submit", function (event) {

                                    //Creating a empty array to store the individual string of OTP
                var valueArray = [];

                inputFields.forEach(function (input) {
                    valueArray.push(input.value);
                });

                //Join the whole array
                const valueCombine = valueArray.join("");

                const xhr = new XMLHttpRequest();

                xhr.onload = function () {
                    // Handle response here
                    console.log(xhr.responseText);
                };

                xhr.open("POST", "doRegistration.php", true);

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                
                xhr.send("otp=" + encodeURIComponent(valueCombine)); //Encoded the data for safer transmission
        });      
        </script>
                                <!-- Ending js code for OTP   -->
</body>
</html>