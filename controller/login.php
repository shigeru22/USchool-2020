<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        include "../include/db_connect.php";
        include "../model/jsonmessage.php";

        $id; $password;

        if(isset($_POST["id"])) $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_ENCODED);
        if(isset($_POST["password"])) $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED);
        echo $id . ' ' . $password;

        $query = "SELECT * FROM user WHERE user_id='$id'";
        $result = $db->query($query);

        if(mysqli_num_rows($result) != 1) {
            $loginInfo = new Message("error", "Wrong email or password.", "none");
        }
        else {
            $user = $result->fetch_assoc();

            if(md5($password) == $user["password"]) {
                $token = md5($user["user_id"] . $user["password"]);
                $_SESSION["uschool-id"] = $id;
                $_SESSION["uschool-token"] = $token;
                $loginInfo = new Message("success", "Login success", $token);
            }
            else {
                $loginInfo = new Message("error", "Wrong email or password.", "none");
            }
        }

        echo json_encode($loginInfo);

        mysqli_free_result($result);
        mysqli_close($db);
    }
    else {
        echo "<script>window.top.location.href = \"..\"</script>";
    }
?>
