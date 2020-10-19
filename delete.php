<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'functions.php';

session_start();
// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
// def vars
$pdo = pdo_conn();
$msg = '';

// check that the poll ID exists
if (isset ($_GET['id'])) {
	// select record which is going to be deleted
	$stmt = $pdo->prepare('SELECT * FROM images where id = ?');
	$stmt->execute([$_GET['id']]);
	$image = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!$image) {
		die ('Image doesn\'t exist');
	}
	// user confirmation of deletion
	if (isset($_GET['confirm'])) {
		if ($_GET['confirm'] == 'yes') {
			// yes -> delete file and record
			unlink($image['path']);
			$stmt = $pdo->prepare('DELETE FROM images WHERE id = ?');
			$stmt->execute([$_GET['id']]);
			// output message
			$msg = 'Deleted';
			?>
            <meta http-equiv="refresh" content="1; URL=index.php">            
            <?php
		} else {
			// no -> redirect home
			header('Location: index.php');
			exit;
		}
	}
} else {
	die ('No ID specified.');
}
?>

<?=header_template('Delete')?>
<div class="content delete">
	<h2>Delete Image <?=$image['title']?></h2>
	<?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete <?=$image['title']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$image['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$image['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=footer_template()?>