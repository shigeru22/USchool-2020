<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <?php
        // everything here is in session
        if(isset($_SESSION["uschool-id"]) && isset($_SESSION["uschool-token"])) {
            include "include/db_connect.php";

            $id = $_SESSION["uschool-id"];
            $query = "SELECT * FROM user WHERE user_id='$id'";
            $result = $db->query($query);

            if(mysqli_num_rows($result) == 1) {
                $user = $result->fetch_assoc();

                if(md5($user["user_id"] . $user["password"]) == $_SESSION["uschool-token"]) {
                    mysqli_free_result($result);
                    mysqli_close($db);

                    echo "<script>window.location.href = \"main\"</script>";
                }
                else {
                    include "view/login.php";
                }
            }
            else {
                include "view/login.php";
            }
        }
        else {
            include "view/login.php";
        }

        if(isset($result)) mysqli_free_result($result);
        if(isset($db)) mysqli_close($db);
    ?>
</html>
