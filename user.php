<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>
    <?php
        include 'header.php';

        $username_id = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        
        $query = "SELECT * FROM users WHERE id = :username_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':username_id', $username_id);
        $statement->execute();
        $result = $statement->fetch();

    ?>

    <h2><?=$result['username']?></h2>

    <img src="profile_uploads/<?=$result['profile_image_name'] . '_medium' . '.' . $result['profile_image_type']?>" alt="profile_picture">

    <form action="server.php?id=<?=$result['id']?>" method="post" id="form">
        <label for="new_username">Enter new username:</label>
        <input type="text" name="new_username">

        <button type="submit" form="form" name="command" value="change_name">Change Username</button>

        <label for="new_username">Enter new password:</label>
        <input type="password" name="new_password">
        <label for="new_username">Confirm new password:</label>
        <input type="password" name="confirm_password">

        <?php if(isset($_SESSION['reg_error'])):?>
            <p><?=$_SESSION['reg_error']?></p>
        <?php endif; ?>

        <button type="submit" form="form" name="command" value="change_password">Change Password</button>

        <button type="submit" form="form" name="command" value="delete_user">Delete User</button>

        <button type="submit" form="form" name="command" value="reset_profile_image">Default Profile Image</button>
    </form>

</body>
</html>