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
                WHERE user_created_characters.build_id = :build_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':build_id', $build_id);
        $statement->execute();	
    ?>

    <?php foreach($statement as $result):?>
        <img src="images/<?=$result['character_name']?>.png" alt="<?=$result['character_name']?>">
        <h1><?=$result['character_name']?></h1>
    <?php endforeach ?>

    <?php
		$query = "SELECT * FROM user_skills 
			JOIN skills ON user_skills.skill_id = skills.skill_id
			WHERE user_skills.build_id = :build_id";
		$statement = $db->prepare($query);
		$statement->bindValue(':build_id', $build_id);
        $statement->execute();		
	?>

    <?php foreach($statement as $skills):?>
        <h2><?=$skills['skill_name']?></h2>
        <p><?=$skills['description']?></p>
    <?php endforeach ?>

    <form action="skills_add.php?build_id=<?=$_GET['build_id']?>" method="post" id="form">
        <button type="submit" form="form" name="command" value="edit_skills">Edit Skills</button>
    </form>

    <form action="server.php?build_id=<?=$_GET['build_id']?>" method="post" id="form">
        <button type="submit" form="form" name="command" value="delete">Delete</button>
    </form>
    </body>
</html>