<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'functions.php';

session_start();
	$host = 'localhost';
	$user = 'root';
	$pass = '4ntonb0r1r@uma';
	$name = 'gallery';
	$charset = 'utf8';

$conn = mysqli_connect($host, $user, $pass, $name);
if ( mysqli_connect_errno() ) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$msg = "";

// input validation
if (!isset($_POST['username'],$_POST['password'])) {
	exit('Please input credentials.');
}
if ($stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?')) {
	// bind parameters (string)
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	// account exists, password verification
		if (password_verify($_POST['password'], $password)) {
			// successful verification, user is logged in
			// create sessions so we know the user is logged in
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			$msg = 'Welcome ' . $_SESSION['name'];
		} else {
			// incorrect password
			$msg = 'Incorrect username/password';
		}
	} else {
		// incorrect username
		$msg = 'Incorrect username/password';
	}

	$stmt->close();
}
?>

<?=header_template('Log in')?>

<div class="content home">
	<h2>Log in</h2>
	<?php if ($msg): ?>
    <h1><?=$msg?></h1>
    <?php endif; ?>
</div>

<?=footer_template()?>