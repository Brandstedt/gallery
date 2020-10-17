<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'functions.php';
?>
<?=header_template('Login')?>

<div class="content home">
	<h2>Log in</h2>
	<div class="login">
		<h1>Log in</h1>
		<form action="auth.php" method="post">
			<label for="username">
				<i class="fas fa-user"></i>
			</label>
			<input type="text" name="username" placeholder="Username" id="username" required>
			<label for="password">
				<i class="fas fa-lock"></i>
			</label>
			<input type="password" name="password" placeholder="Password" id="password" required>
			<input type="submit" class="button" value="Login">
		</form>
		<a href="register.php" class="button">Sign up</a>
	</div>
</div>

<?=footer_template()?>