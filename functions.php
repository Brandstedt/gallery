<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function pdo_conn() {
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$name = 'gallery';
	$charset = 'utf8';
	
	try {
    	return new PDO('mysql:host=' . $host . ';dbname=' . $name . ';charset=utf8', $user, $pass);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	die ('Error: Connection to database failed.');
    }
}

// header template
function header_template($title) {
	echo <<<EOT
	<!DOTCTYPE html>
	<html>
		<head>
			<meta charset="utf8">
			<meta name="viewport" content="width=device-width,minimum-scale=1">
			<title>$title</title>
			<link href="gallery.css" rel="stylesheet" type="text/css">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
			<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
			<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
			<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
			<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
			<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
			<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
			<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
			<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
			<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
			<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
			<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
			<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
			<meta name="msapplication-TileColor" content="#ffffff">
			<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
			<meta name="theme-color" content="#ffffff">		
		</head>
		<body>
		<nav class="navtop">
			<div>
				<a href="index.php">Home</a>
			</div>
		</nav>

	EOT;
}
// footer template
function footer_template() {
echo <<<EOT
	</body>
	<script type="text/javascript" src="script.js" charset=utf-8" defer></script>
</html>
EOT;
}
?>