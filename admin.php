<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>
    <?php
        include 'header.php';

        $query = "SELECT * FROM users";
        $statement = $db->prepare($query);
        $statement->execute();
    ?>
    <p> Currently active users: </p>

    <?php foreach($statement as $statement):?>
        <ul>
            <li><img src="profile_uploads/<?=$statement['profile_image_name'] . '_thumbnail' . '.' . $statement['profile_image_type']?>" alt="profile_picture">
            <a href="user.php?user_id=<?=$statement['id']?>"><?=$statement['username']?></a></li>
        </ul>
    <?php endforeach ?>

    <form action="server.php" method="post" id="form">
        <p> Create new users: </p>
        <?php if(isset($_SESSION['reg_error'])):?>
            <p><?=$_SESSION['reg_error']?></p>
        <?php endif; ?>


        <div>
            <label for="username">Username</label>
            <input type="text" name="username" required>

        </div>

        <div>

            <label for="email">Email</label>
            <input type="email" name="email" required>

        </div>

        <div>

            <label for="password">Password</label>
            <input type="password" name="password_1" required>

        </div>

        
        <div>

            <label for="password">Confirm Password</label>
            <input type="password" name="password_2" required>

        </div>
    </form>
</body>
</html>
