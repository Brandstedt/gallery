<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'functions.php';

$host = 'localhost';
$user = 'root';
$pass = '';
$name = 'gallery';
$charset = 'utf8';

$conn = mysqli_connect($host, $user, $pass, $name);
if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// def vars & init
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // set parameters
            $param_username = trim($_POST["username"]);
            
            // attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // close connection
    mysqli_close($conn);
}
?>

<?=header_template('Login')?>

<div class="content home">
    <h2>Sign up</h2>
    <div class="login">
    <h1>Sign up</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

       
        <input type="text" name="username" placeholder="Username" id="username" required>
        <span><?php echo $username_err; ?></span>
       
        <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
        <span><?php echo $password_err; ?></span>
       
       
        <input type="password" name="confirm_password" placeholder="Confirm password" value="<?php echo $confirm_password; ?>">
        <span><?php echo $confirm_password_err; ?></span>

        <input type="submit" class="button" value="Submit">
        <input type="reset" class="button" value="Reset">

        <p>Already have an account? <a href="login.php" class="button">Log in here</a></p>
    </form>
    </div>
</div>