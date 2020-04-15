<?php
    include 'ImageResize.php';
    include 'ImageResizeException.php';
    
    use Gumlet\ImageResize;

    function file_upload_path($original_filename, $upload_subfolder_name = 'profile_uploads') {
       $current_folder = dirname(__FILE__);
       
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = mime_content_type($temporary_path);
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }
    
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

    if ($image_upload_detected) { 
        $image_filename        = $_FILES['image']['name'];
        $temporary_image_path  = $_FILES['image']['tmp_name'];
        $new_image_path        = file_upload_path($image_filename);
        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            move_uploaded_file($temporary_image_path, $new_image_path);

            $image = new ImageResize($new_image_path);
            $image->resizeToWidth(400);
            $image->save('./profile_uploads/' . pathinfo($image_filename, PATHINFO_FILENAME) . '_medium.' . pathinfo($image_filename, PATHINFO_EXTENSION));

            $image = new ImageResize($new_image_path);
            $image->resizeToWidth(50);
            $image->save('./profile_uploads/' . pathinfo($image_filename, PATHINFO_FILENAME) . '_thumbnail.' . pathinfo($image_filename, PATHINFO_EXTENSION));
        }
    }
?>
 <!DOCTYPE html>
 <html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <title>FE: CHARACTER BUILDER</title>
    </head>
 <body>

    <?php
        include 'header.php';
    ?>

    <form action="" method="POST" enctype='multipart/form-data'>
         <label for='image'>Image Filename:</label>
         <input type='file' name='image' id='image'>
         <input type='submit' name='submit' value='Upload Image'>
    </form>

    <form action="server.php" method="POST">
        <input type="hidden" id="username_id" name="username_id" value="<?=$result['id']?>">
        <button type="submit" name="command" value="delete_image">Reset Profile Picture</button>
    </form>
     
    <?php if ($upload_error_detected): ?>

        <p>Error Number: <?= $_FILES['image']['error'] ?></p>

    <?php elseif ($image_upload_detected): ?>

        <img src="profile_uploads/<?= $_FILES['image']['name'] ?>" alt="<?= $_FILES['image']['name'] ?>">

        <?php if(isset($_SESSION['login'])):?>
            <h5>Is this the image you would like to use as your profile picture?</h5>
            <?php 
                $username = $_SESSION['username'];

                $query = "SELECT * FROM users 
                            WHERE username = :username";
                $user = $db->prepare($query);
                $user->bindValue(':username', $username);
                $user->execute();
                $result = $user->fetch();

                $image = explode(".", $_FILES['image']['name']);
            ?>

        <form action="server.php" method="POST" enctype='multipart/form-data'>
            <input type="hidden" id="image_name" name="image_name" value="<?=$image[0]?>">
            <input type="hidden" id="username_id" name="username_id" value="<?=$result['id']?>">
            <input type="hidden" id="type" name="type" value="<?=strtolower($image[1])?>">
            <button type="submit" name="command" value="change_image">Yes</button>
        </form>

        <?php endif ?>


    <?php endif ?>
 </body>
 </html>