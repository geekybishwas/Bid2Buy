<?php


echo $_POST['data'];

?>
<?php
    
    // Check if a form is submitted and which one
    if (isset($_POST['Verify']) && $_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // var_dump(isset($_POST['Verify']));
        echo $_POST['Verify'];
        // die("sakiyo hai");
    ?>
        <script> 
            document.getElementById("otpForm").classList.add("hidden");
            document.getElementById("retrievePassword").classList.remove("hidden");
        </script>

    <?php 
    
    }
    else 
    {
        if(isset($_POST['retrievePassword']))
        {
    ?>
            <!-- <script>
                    // document.getElementById("otpForm").classList.remove("hidden");
                    // document.getElementById("otpForm").classList.add("hidden");
            </script> -->
    <?php
                die("passwordd ma aayo");

                $password=$_POST['password'];
                $confirmPassword=$_POST['rPassword'];

                if(strcmp($password,$confirmPassword))
                {
                    echo "<script>alert('Password must match')</script>";
                }
                else
                {
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
    }
    }

                ?>