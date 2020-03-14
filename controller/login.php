<?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        include "../include/db_connect.php";

        $id; $password;

        if(isset($_POST["id"])) $id = $_POST["id"];
        if(isset($_POST["password"])) $password = $_POST["password"];

        $query = "SELECT * FROM user WHERE user_id='$user_id'"
        $result = $db->query($query);

        if(mysqli_num_rows($result) != 1) {
            $loginInfo->message = "error";
            $loginInfo->description = "Wrong email or password.";

            echo json_encode($loginInfo);
        }
        else {
            $user = $result->fetch_assoc();

            if(md5($password) == $user["password"]) {
                $loginInfo->message = "success";
                $loginInfo->token = "md5($user . $password)";

                echo json_encode($loginInfo);
            }
            else {
                $loginInfo->message = "error";
                $loginInfo->description = "Wrong email or password.";

                echo json_encode($loginInfo);
            }
        }

        mysqli_free_result($result);
        mysqli_close($db);
    }
    else {
        echo "<script>window.top.location.href = \"..\"</script>";
    }
?>
