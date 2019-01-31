<?php
    ini_set("session.cookie_httponly", 1);
    session_start();

    require 'database.php';

    //check for empty fields
    $username1 = htmlentities($_POST['username']);
    if (empty(htmlentities($_POST['username'])) || empty(htmlentities($_POST['password'])) ||  empty(htmlentities($_POST['password2']))) {
        echo json_encode(array(
            "success" => false,
            "message" => "One or more fields are empty!"
        ));
        exit();
    }
else {
    if (htmlentities($_POST['password']) !== htmlentities($_POST['password2'])){
        echo json_encode(array(
            "success" => false,
            "message" => "Password does not match!"
        ));
        exit();
    }
    else {
    //check if input char is valid
    if (!preg_match("/^[a-zA-Z]*$/", htmlentities($_POST['username']))){
        echo json_encode(array(
            "success" => false,
            "message" => "Username is invalid!"
        ));
        exit();
    }
        else {
            //check if username taken
            $sql = "SELECT * FROM users WHERE user_uid='" . $mysqli->real_escape_string(htmlentities($_POST['username'])) . "'";
            $result = mysqli_query($mysqli, $sql);
            $resultCheck = mysqli_num_rows($result);
        
            if ($resultCheck > 0) {
                echo json_encode(array(
                    "success" => false,
                    "message" => "Username is taken!"
                ));
                exit();
            }
            else {
                //password hash
                $pwdHash = password_hash(htmlentities($_POST['password']), PASSWORD_BCRYPT);

                $sql = "INSERT INTO users (user_uid, user_pwd) VALUES ('" . htmlentities($_POST['username']) . "', '$pwdHash');";
                mysqli_query($mysqli, $sql);

                $_SESSION['user'] = $username1;
                unset($_SESSION['user']);
                unset($_SESSION['u_id']);
                session_unset();
                session_destroy();
                echo json_encode(array(
                      "success" => true,
                      "message" => "Signed up successful!"
                  ));
                exit();
            }

        }

    }

}