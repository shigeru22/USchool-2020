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
                        $userid; $fname; $lname; $roleid; $address; $password;

                        if(isset($_POST["userid"])) $userid = $_POST["userid"];
                        if(isset($_POST["fname"])) $fname = $_POST["fname"];
                        if(isset($_POST["lname"])) $lname = $_POST["lname"];
                        if(isset($_POST["role"])) $roleid = $_POST["role"];
                        if(isset($_POST["address"])) $address = $_POST["address"];
                        if(isset($_POST["password"])) $password = $_POST["password"];

                        $query = "SELECT * FROM user WHERE user_id='$userid'";
                        $result = $db->query($query);

                        if(mysqli_num_rows($result) != 0) {
                            $insertInfo = new Message("error", "User ID already exists.", "none");
                        }
                        else {
                            $hash = md5($password);
                            if($db->query("INSERT INTO user (user_id, password, first_name, last_name, role_id, address) VALUES ('$userid', '$hash', '$fname', '$lname', $roleid, '$address')") === true) {
                                $insertInfo = new Message("success", "User of " . $userid . " has been inserted.", "none");
                            }
                            else {
                                $insertInfo = new Message("error", "Query error occured.", "none");
                            }
                        }
                    }
                    else $insertInfo = new Message("error", "No permission for currently logged in User ID.", "none");

                    echo json_encode($insertInfo);
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
