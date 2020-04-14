<?php
    require 'connect.php';

    if($_POST['command'] == 'signup'){

        session_start();

        $_SESSION['reg_error'] = "";

        $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password  = filter_input(INPUT_POST, 'password_1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password2 = filter_input(INPUT_POST, 'password_2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query); 
        $statement->bindValue(':username', $username);

        $statement->execute();

        $result = $statement->fetch();

        if($username === $result['username']){
            $_SESSION['reg_error'] = "Username is already taken, try again.";
            header('location: signup.php');
        }
        else if($password != $password2){
            $_SESSION['reg_error'] = "Passwords do not match, try again.";
            header('location: signup.php');
        }
        else{
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query= "INSERT INTO users (id, username, password, email) values (NULL, :username, :password, :email)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':password', $password); 
            $statement->bindValue(':email', $email);
            $statement->execute();
            $insert_id = $db->lastInsertId();

            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;    
            header('location: index.php');
        }
    }

    if($_POST['command'] == 'login'){

        session_start();

        $_SESSION['log_error'] = [];
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password_1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $db->prepare($query); 
        $statement->bindValue(':username', $username);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_BOTH);

        if(password_verify($password, $result['password'])){
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;    
            header('location: index.php');
        }
        else{
            $_SESSION['login'] = false;
            $_SESSION['log_error'] = "Username or password is incorrect.";
            header('location: login.php');
        }
    }

    if($_POST['command'] == 'create'){

        session_start();

        if(isset($_SESSION['username'])){

            $query = "SELECT * FROM user_created_characters ORDER BY build_id DESC LIMIT 1";
            $statement = $db->prepare($query);
            $statement->execute();
            $result = $statement->fetch();

            $build_id = $result['build_id'];
            $build_id = $build_id + 1;

            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $character  = filter_input(INPUT_POST, 'character', FILTER_SANITIZE_NUMBER_INT);
            $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_NUMBER_INT);
            
            $query = "INSERT INTO user_created_characters (build_id, build_title, character_id, class, username_id, date_created) values ('$build_id', :title, :character, :class, :userid, NULL)";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':character', $character);        
            $statement->bindValue(':class', $class);
            $statement->bindValue(':userid', $userid);
             
            $statement->execute();

            $query = "SELECT * FROM user_created_characters WHERE username_id = :userid";
            $statement = $db->prepare($query);
            $statement->bindValue(':userid', $userid);
            $statement->execute();
            $result = $statement->fetch();

            header('location: skills_add.php?build_id=' . $build_id);
        }
    }

    if($_POST['command'] == 'skills'){

        session_start();

        if(isset($_SESSION['username'])){

            $build_id = filter_input(INPUT_POST, 'build_id', FILTER_SANITIZE_NUMBER_INT);
            // $skills = filter_input_array(INPUT_POST, 'skills', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            foreach($_POST['skill'] as $skill){ 
                // $skill = filter_input_array(INPUT_POST, $skill, FILTER_SANITIZE_NUMBER_INT);
                $query = "INSERT INTO user_skills (build_id, skill_id) values (:build_id, :skill_id)";
                $statement = $db->prepare($query);
                $statement->bindValue(':build_id', $build_id);        
                $statement->bindValue(':skill_id', $skill);    
                $statement->execute();

                header('location: index.php');
            }
        }

    }

    if($_POST['command'] == 'delete'){

        session_start();

        if(isset($_SESSION['username'])){

            $build_id = filter_input(INPUT_GET, 'build_id', FILTER_SANITIZE_NUMBER_INT);

            $query = "DELETE FROM user_created_characters WHERE build_id = :build_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':build_id', $build_id);         
            $statement->execute();
            
            header('location: index.php');
        }
        
    }

    if($_POST['command'] == 'edit_skills'){

        session_start();

        if(isset($_SESSION['username'])){

            $build_id = filter_input(INPUT_POST, 'build_id', FILTER_SANITIZE_NUMBER_INT);

            $query = "DELETE FROM user_skills WHERE build_id = :build_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':build_id', $build_id);         
            $statement->execute();

            foreach($_POST['skill'] as $skill){ 
                $query = "INSERT INTO user_skills (build_id, skill_id) values (:build_id, :skill_id)";
                $statement = $db->prepare($query);
                $statement->bindValue(':build_id', $build_id);        
                $statement->bindValue(':skill_id', $skill);    
                $statement->execute();
            }

            header('location: index.php');
        }
    }


    if($_POST['command'] == 'comment'){

        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $build = filter_input(INPUT_POST, 'build', FILTER_SANITIZE_NUMBER_INT);
        $author  = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_NUMBER_INT);

        $query = "INSERT INTO comments (comment_id, author_id, content, build_id) values (NULL, :author_id, :content, :build_id)";
        $statement = $db->prepare($query);
        $statement->bindValue(':build_id', $build);        
        $statement->bindValue(':author_id', $author);    
        $statement->bindValue(':content', $comment);    
        $statement->execute();

        header('location: focus.php?build_id=' . $build);

    }
  
?>  