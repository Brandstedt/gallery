<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'functions.php';

// connect to MySQL
$pdo = pdo_conn();
// define sorting options, sort by newest is default
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'newest';
$sort_by_sql = 'upload_date DESC';
$sort_by_sql = $sort_by == 'newest' ? 'upload_date DESC' : $sort_by_sql;
$sort_by_sql = $sort_by == 'oldest' ? 'upload_date ASC' : $sort_by_sql;
$sort_by_sql = $sort_by == 'a_to_z' ? 'title ASC' : $sort_by_sql;
$sort_by_sql = $sort_by == 'z_to_a' ? 'title DESC' : $sort_by_sql;

// query all images in database
$stmt = $pdo->query('SELECT * FROM images ORDER BY ' . $sort_by_sql . '');
if ($stmt) {
	$images=$stmt->fetchAll(PDO::FETCH_ASSOC);	
}
ELSE {
	echo "Error: The query executed unsuccessfully";
}
// set image properties
$image_width = 320;
$image_height = 210;
?>

<?=header_template('Anton\'s gallery')?>

<div class="content home">
	<h2>Image wall</h2>
	<div class="con">
		<?php
		session_start();
		// if a user is logged in, display logout button
		if (!isset($_SESSION['loggedin'])) {
			?>
			<a href="login.php" class="upload-image">Log in</a>
			<?php
		} else {
			?>
			<a href="upload.php" class="upload-image">Upload image</a>
			<a href="logout.php" class="upload-image">Log out</a>
			<?php
		}
		?>
		<form class="form" action="" method="get">
			<label class="label" for="sort_by">Sort by:</label>
			<select id="sort_by" name="sort_by" onchange="this.form.submit()">
				<option value="newest"<?=$sort_by=='newest'?' selected':''?>>Newest</option>
				<option value="oldest"<?=$sort_by=='oldest'?' selected':''?>>Oldest</option>
				<option value="a_to_z"<?=$sort_by=='a_to_z'?' selected':''?>>A-Z</option>
				<option value="z_to_a"<?=$sort_by=='z_to_a'?' selected':''?>>Z-A</option>
			</select>
		</form>
	</div>
	<div class="images">
		<?php foreach ($images as $image): ?>
		<?php if (file_exists($image['path'])): ?>
		<a href="#" style="width:<?=$image_width?>px;height:<?=$image_height?>px;">
			<img src="<?=$image['path']?>" alt="<?=$image['description']?>" data-id="<?=$image['id']?>" data-title="<?=$image['title']?>" width="<?=$image_width?>" height="<?=$image_height?>">
			<span class="description"><?=$image['description']?></span>
		</a>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
	<span id='toTopBtn' onclick='toTop()'>^</span>
</div>
<div class="image-popup"></div>

<?=footer_template()?>