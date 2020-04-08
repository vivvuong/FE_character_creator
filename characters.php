<?php
    require 'connect.php';
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
        $query = "SELECT * FROM house";
        $house = $db->prepare($query); 
        $house->execute(); 
	?>

    <form action="" method="POST">
        <label for="sort">Sort by:</label>
            <select name="sort">
                <option value="0">All</option>
                <?php foreach($house as $house):?>
                    <option value="<?=$house['house_id']?>"><?=$house['house_name']?></option>
                <?php endforeach ?>
        </select>
        <button type="submit" name="command" value="submit">Submit</button>
    </form>

    <?php if(isset($_POST['command'])):?>
        <?php
            $sort = filter_input(INPUT_POST, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $query = "SELECT * FROM characters WHERE house_id = :sort";
            $statement = $db->prepare($query); 
            $statement->bindValue(':sort', $sort);
            $statement->execute(); 
        ?>

         <div id="characters">
            <?php foreach($statement as $statement): ?>
                <a href="select.php?character=<?=$statement['character_name']?>"><img src="images/<?=$statement['character_name']?>.png" alt="<?=$statement['character_name']?>"></a>
            <?php endforeach ?>
        </div>

        <?php if($sort == "0"):?>
           <?php
                $query = "SELECT * FROM characters";
                $statement = $db->prepare($query); 
                $statement->execute(); 
            ?>
            <div id="characters">
                <?php foreach($statement as $statement): ?>
                    <a href="select.php?character=<?=$statement['character_name']?>"><img src="images/<?=$statement['character_name']?>.png" alt="<?=$statement['character_name']?>"></a>
                <?php endforeach ?>
            </div>
        <?php endif; ?>
        
    
    <?php else:?>
        <?php
            $query = "SELECT * FROM characters";
            $statement = $db->prepare($query); 
            $statement->execute(); 
        ?>
        <div id="characters">
            <?php foreach($statement as $statement): ?>
                <a href="select.php?character=<?=$statement['character_name']?>"><img src="images/<?=$statement['character_name']?>.png" alt="<?=$statement['character_name']?>"></a>
            <?php endforeach ?>
        </div>
    <?php endif;?>
</body>
</html>