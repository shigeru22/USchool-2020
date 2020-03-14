<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <?php
        // everything here is in session
        if(isset($_SESSION["uschool-id"]) && isset($_SESSION["uschool-token"])) {
            include "../include/db_connect.php";
            include "../model/users.php";
            include "../model/roles.php";
            include "../model/grades.php";

            $id = $_SESSION["uschool-id"];
            $result = $db->query("SELECT * FROM user WHERE user_id='$id'");

            if(mysqli_num_rows($result) == 1) {
                $user = $result->fetch_assoc(); // user variable

                if(md5($user["user_id"] . $user["password"]) == $_SESSION["uschool-token"]) {
                    // logged in
                    $currUser = new User($user["user_id"], $user["first_name"], $user["last_name"], $user["role_id"], $user["address"]);
                    unset($user);

                    $roles = array();
                    $result = $db->query("SELECT * FROM role");
                    while($row = $result->fetch_assoc()) {
                        array_push($roles, new Role($row["role_id"], $row["role_name"], $row["role_desc"]));
                    }

                    $grades = array();
                    $result = $db->query("SELECT * FROM grade");
                    while($row = $result->fetch_assoc()) {
                        array_push($grades, new Grade($row["user_id"], $row["nilai_tugas"], $row["nilai_uts"], $row["nilai_uas"]));
                    }

                    $i = 0;
                    while($i < count($roles)) {
                        if($currUser->getRoleId() == $roles[$i]->getId()) {
                            include "../view/" . $roles[$i]->getName() . ".php";
                            break;
                        }
                    }
                }
                else {
                    echo "<script>window.location.href = \"..\"</script>";
                }
            }
            else {
                echo "<script>window.location.href = \"..\"</script>";
            }
        }
        else {
            echo "<script>window.location.href = \"..\"</script>";
        }

        mysqli_free_result($result);
        mysqli_close($db);
    ?>
</html>
