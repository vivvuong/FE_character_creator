<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<title>FE: CHARACTER BUILDER</title>
</head>
<body>
    <?php
        include 'header.php';
        $character = filter_input(INPUT_GET, 'character', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM characters 
                    JOIN personal_skills ON personal_skills.personal_id = characters.personal_skill
                    WHERE characters.character_name = :character";
        $statement = $db->prepare($query); 
        $statement->bindValue(':character', $character);
        $statement->execute(); 
    ?>
    
    <img src="images/<?=$character?>.png" alt="selected character">
    <h2><?=$character?></h2>
    <ul>
        <?php foreach($statement as $statement): ?>
            <li><?=$statement['character_name']?></li>
            <li><?=$statement['description']?></li>
        <?php endforeach ?>
    </ul>
</body>
</html>