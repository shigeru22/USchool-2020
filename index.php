<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <?php
        // everything here is in session
        if(isset($_SESSION["uschool-id"])) {
            include "include/db_connect.php";

            $query = "SELECT * FROM user";
            $result = $db->query($query);
        }
        else {
            include "view/login.php";
        }
    ?>
</html>
