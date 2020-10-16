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

// set max upload file size
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');
// output message
$msg = '';
// check if user has uploaded new image
if (isset($_FILES['image'], $_POST['title'], $_POST['description'])) {
    // directory where the images will be stored
    $target_dir = 'images/';
    // path of the new image file
    $image_path = $target_dir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    // validate file
    if (!empty($_FILES['image']['tmp_name']) && getimagesize($_FILES['image']['tmp_name'])) {
        if (file_exists($image_path)) {
            $msg = 'File already exists, chose another or rename file.';
        }
        else if ($_FILES['image']['size'] > 20000000) {
            $msg = 'File size too big, max 20MB';
        }
        else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $msg = 'Invalid extension';
        }
        else {
            // move uploaded image file to the server
            if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path) && is_writable($image_path)) {
                // connect to DB
                $pdo = pdo_conn();
                // insert image metadata into the database
                $stmt = $pdo->prepare('INSERT INTO images VALUES (NULL, ?, ?, ?, CURRENT_TIMESTAMP)');
                $stmt->execute([$_POST['title'], $_POST['description'], $image_path]); 
                $msg = 'Image uploaded successfully';
                sleep(1.5);
                header('Location: index.php');                
            } else {
                $msg = 'Error uploading image';
            }                       
        }
    } else {
        $msg = 'No file chosen';
    }
}
?>

<?=header_template('Upload Image')?>
<div class="content upload">
    <h2>Upload Image</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Coose image</label>
        <input type="file" name="image" accept="image/*" id="image">
        <label for="title">Title</label>
		<input type="text" name="title" id="title">
		<label for="description">Description</label>
		<textarea name="description" id="description"></textarea>
	    <input type="submit" value="Upload Image" name="submit">
	</form>
	<p><?=$msg?></p>
    <?php if ($msg == 'Image uploded successfully') {
        sleep(1.5);
        header('Location: index.php');
    }
    ?>
</div>

<?=footer_template()?>