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

                    if($roles[$currUser->getRoleId() - 1]->getName() == "guru") {
                        $userid; $works; $mid; $final;

                        if(isset($_POST["userid"])) $userid = $_POST["userid"];
                        if(isset($_POST["works"])) $works = $_POST["works"];
                        if(isset($_POST["mid"])) $mid = $_POST["mid"];
                        if(isset($_POST["final"])) $final = $_POST["final"];

                        $query = "SELECT * FROM grade WHERE user_id='$userid'";
                        $result = $db->query($query);

                        if(mysqli_num_rows($result) != 1) {
                            $updateInfo = new Message("error", "User ID not found.", "none");
                        }
                        else {
                            $user = $result->fetch_assoc();

                            if($user["nilai_tugas"] == $works && $user["nilai_uts"] == $mid && $user["nilai_uas"] == $final) {
                                $updateInfo = new Message("unchanged", "No field has been changed.", "none");
                            }
                            else {
                                if($db->query("UPDATE grade SET nilai_tugas=$works, nilai_uts=$mid, nilai_uas=$final WHERE user_id='$userid'") === true) {
                                    $updateInfo = new Message("success", "Grade of user " . $targetId . " has been updated.", "none");
                                }
                                else {
                                    $updateInfo = new Message("error", "Query error occured: " . $db->error, "none");
                                }
                            }
                        }
                    }
                    else $updateInfo = new Message("error", "No permission for currently logged in User ID.", "none");

                    echo json_encode($updateInfo);
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
