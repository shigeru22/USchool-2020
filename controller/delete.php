<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        if(isset($_SESSION["uschool-id"]) && isset($_SESSION["uschool-token"])) {
            include "../include/db_connect.php";
            include "../model/users.php";
            include "../model/roles.php";
            include "../model/jsonmessage.php";

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

                    if($roles[$currUser->getRoleId() - 1]->getName() == "admin") {
                        $targetId;

                        if(isset($_POST["userid"])) $targetId = $_POST["userid"];

                        $query = "SELECT * FROM user WHERE user_id='$targetId'";
                        $result = $db->query($query);

                        if(mysqli_num_rows($result) != 1) {
                            $delInfo = new Message("error", "User ID not found.", "none");
                        }
                        else {
                            if($db->query("DELETE FROM user WHERE user_id='$targetId'") === true) {
                                $delInfo = new Message("success", "User of " . $targetId . " has been deleted.", "none");
                            }
                            else {
                                $delInfo = new Message("error", "Query error occured.", "none");
                            }
                        }
                    }
                    else $delInfo = new Message("error", "No permission for currently logged in User ID.", "none");

                    echo json_encode($delInfo);
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
    }
    else {
        echo "<script>window.top.location.href = \"..\"</script>";
    }

    mysqli_free_result($result);
    mysqli_close($db);
?>
