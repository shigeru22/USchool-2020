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

                    if($roles[$currUser->getRoleId() - 1]->getName() == "guru") {
                        $targetId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_ENCODED);
                        $result = $db->query("SELECT * FROM grade WHERE user_id='$targetId'");

                        if(mysqli_num_rows($result) == 1) {
                            $gradeQuery = $result->fetch_assoc();
                            $grade = new Grade($gradeQuery["user_id"], $gradeQuery["nilai_tugas"], $gradeQuery["nilai_uts"], $gradeQuery["nilai_uas"]);
                            unset($gradeQuery);

                            $result = $db->query("SELECT * FROM user WHERE user_id='$targetId'");
                            $userQuery = $result->fetch_assoc();
                            $user = new User($userQuery["user_id"], $userQuery["first_name"], $userQuery["last_name"], $userQuery["role_id"], $userQuery["address"]);
                            unset($userQuery);

                            include "../view/editgrade.php";
                        }
                        else include "../view/usernotfound.php";
                    }
                    else include "../view/permissionerror.php";
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
