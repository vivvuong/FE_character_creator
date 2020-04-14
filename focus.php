<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>
    <?php
        include 'header.php';
        require 'connect.php';

        $build_id  = filter_input(INPUT_GET, 'build_id', FILTER_SANITIZE_NUMBER_INT);

        $query = "SELECT * FROM user_created_characters 
				JOIN characters ON user_created_characters.character_id = characters.character_id
				JOIN users ON user_created_characters.username_id = users.id
				JOIN classes ON user_created_characters.class = classes.class_id
				WHERE build_id = :build_id";
        $statement = $db->prepare($query); 
        $statement->bindValue(':build_id', $build_id);
        $statement->execute(); 
    ?>

    <?php foreach($statement as $user):	?>
		<?php
			$build_id = $user['build_id'];
			$class_id = $user['class'];

			$query = "SELECT * FROM class_skills  
				JOIN skills on class_skills.class_skill = skills.skill_id
				WHERE class_id = :class_id";
			$class = $db->prepare($query);
			$class->bindValue(':class_id', $class_id);
			$class->execute();

			$query = "SELECT * FROM user_skills 
				JOIN skills ON user_skills.skill_id = skills.skill_id
				WHERE build_id = :build_id";
			$statement = $db->prepare($query);
			$statement->bindValue(':build_id', $build_id);
			$statement->execute();		
		?>

		<h1><?=$user['build_title']?></h1>

		<img src="images/<?=$user['character_name']?>.png" alt="<?=$user['character_name']?>">
		<h1><?=$user['character_name']?> / <?=$user['class_name']?></h2>

		<?php if(isset($_SESSION['login']) && isset($_SESSION['username'])):?>
			<?php if($_SESSION['username'] === $user['username']):?>
				<a href="edit.php?build_id=<?=$build_id?>">Edit</a>
			<?php endif ?>
		<?php endif ?>

		<h1>CLASS SKILLS</h1>
		<?php foreach($class as $class):?>
			<h2> <?=$class['skill_name']?> </h2>
			<p> <?=$class['description']?> </p>
		<?php endforeach ?>
		<h1>ASSIGNED SKILLS</h1>
		<?php foreach($statement as $skills):?>
			<h2> <?=$skills['skill_name']?> </h2>
			<p> <?=$skills['description']?> </p>
		<?php endforeach ?>
	<?php endforeach ?>


    <?php if(isset($_SESSION['login'])):?>
        <?php 
            $username = $_SESSION['username'];

            $query = "SELECT * FROM users 
                        WHERE username = :username";
            $user = $db->prepare($query);
            $user->bindValue(':username', $username);
            $user->execute();
            $result = $user->fetch();
        ?>


        <form action="server.php" method="POST">

            <label for="fname">Add a comment:</label>
            <input type="text" id="comment" name="comment">
            <input type="hidden" id="build_id" name="build" value="<?=$build_id?>">
            <input type="hidden" id="author_id" name="author" value="<?=$result['id']?>">
            <button type="submit" name="command" value="comment">Submit</button>
            
        </form>
    <?php endif ?>


    <?php 
        $query = "SELECT * FROM comments
            JOIN users ON comments.author_id = users.id
            WHERE build_id = :build_id";
        $comment = $db->prepare($query); 
        $comment->bindValue(':build_id', $build_id);
        $comment->execute(); 
    ?>
    <?php foreach($comment as $comment):?>
        <p><?=$comment['content']?></p>
        <p>By <?=$comment['username']?></p>
    <?php endforeach ?>


</body>
</html>
