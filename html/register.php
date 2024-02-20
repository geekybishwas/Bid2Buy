<?php

require_once "../php/connectDB.php";

if(isset($_POST["Register"]) && ($_SERVER["REQUEST_METHOD"]=="POST") && isset($_POST["accountType"]))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contactNumber=$_POST['phnNumber'];
    $password=$_POST['password'];
    $confirmPassword=$_POST['rPassword'];
    
    $accountType=$_POST['accountType'];


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
            return $user;    
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


    //Checking user already exist or not
    if(emailExist($conn,$email))
    {
        echo "<script>alert(Email already exist)</script>";
        header("Location: ../register.php");
    }
    elseif(nameExist($conn,$name))
    { 
        echo "<script>alert(Email already exist)</script>";
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
            // $emailSentOrNot=emailVerification($name,$email,$otp);
            $passwordHash=password_hash($password,PASSWORD_DEFAULT);

            //Creating sql query
            $sql="INSERT INTO Customer (name,email,contactNumber,passwordHash,country,accountType) VALUES(?,?,?,?,?,?)";

            //Prepare it for execution for prepare function
            $stmt = mysqli_prepare($conn, $sql);


            //Checking
            if (!$stmt) {
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
                header("Location: ../html/signin.php");
              }
              else
              {
              echo "<script>Verification succesfully</script>";
              }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bid2Buy | Register</title>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="../css/register_signIn_style.css" />
    <link rel="stylesheet" href="../css/header_only.css" />
    <script src="../js/register.js"></script>
    <script src="../js/get_back_btn.js"></script>
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
  </head>

  <body>
    <header>
      <nav class="first_nav">
        <div class="left_part">
          <a href="../index.html">
            <div class="logo">
              <!-- <img src="../assets/logo_main.png" alt="B2B" /> -->
              <h1>Bid2Buy</h1>
            </div>
          </a>
          <ul class="nav_btns">
            <li>
              <h2 class="page_title">User Registration</h2>
            </li>
          </ul>
        </div>
        <div class="authentication">
          <h3 class="get_back_btn authentication_btn">❌ Cancel</h3>
        </div>
      </nav>
    </header>
    <main>

      <img src="../assets/register_bcg.png" alt="Man with Auction Hammer" />
      <!-- <h2>Create Account</h2> -->
      <div class="wrapper">
        <div class="form-container register">
          <form>
            <div class="label">Choose Account Type</div>
            <div class="row_align">
              <input
                type="radio"
                id="seller"
                name="accountType"
                value="seller"
              />
              <label for="seller">Seller</label>

              <input type="radio" id="buyer" name="accountType" value="buyer" />
              <label for="buyer">Buyer</label>
            </div>
            <input placeholder="Name" type="text" id="name" name="name" required />
            <input placeholder="Email Address" type="email" id="email" name="email" required />
            <input placeholder="Phone Number" type="tel" id="phone_number" name="phone_number" required />
            <div class="password_wrapper">
              <input
            placeholder="Password"
              class="register-password"
              type="password"
              id="password"
              name="password"
              required
            /><i
            class="fa fa-eye-slash toggle-password"
            id="toggle-password"
          ></i>
            </div>
            <div class="password_wrapper">
              <input
            placeholder="Repeat Password"
              class="register-password"
              type="password"
              id="r-password"
              name="r-password"
              required
            /><i
            class="fa fa-eye-slash toggle-password"
            id="toggle-repeat-password"
          ></i>
            </div>
            <div class="row_align">
              <input type="checkbox" name="terms" id="terms" required />
              <label
                >I agree to all
                <span class="pop-up-on-click"
                  >terms and conditions</span
                >!</label
              >
            </div>
            <input id="register-submit" type="submit" value="Register" name="Register"/>
          </form>
          <div class="toggle goto-login">
            Already a member?<a href="./signin.html">Sign In</a>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
