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
                        $userid; $fname; $lname; $roleid; $currrole; $address;

                        if(isset($_POST["userid"])) $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_ENCODED);
                        if(isset($_POST["fname"])) $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_ENCODED);
                        if(isset($_POST["lname"])) $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_ENCODED);
                        if(isset($_POST["role"])) $roleid = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_ENCODED);
                        if(isset($_POST["currentrole"])) $currrole = filter_input(INPUT_POST, 'currentrole', FILTER_SANITIZE_ENCODED);
                        if(isset($_POST["address"])) $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);

                        $query = "SELECT * FROM user WHERE user_id='$userid'";
                        $result = $db->query($query);

                        if(mysqli_num_rows($result) != 1) {
                            $updateInfo = new Message("error", "User ID not found.", "none");
                        }
                        else {
                            $queriedUser = $result->fetch_assoc();
                            $targetUser = new User($queriedUser["user_id"], $queriedUser["first_name"], $queriedUser["last_name"], $queriedUser["role_id"], $queriedUser["address"]);
                            unset($queriedUser);

                            if($targetUser->getFName() == $fname && $targetUser->getLName() == $lname && $targetUser->getRoleId() == $roleid && $targetUser->getAddress() == $address) {
                                $updateInfo = new Message("unchanged", "No field has been changed.", "none");
                            }
                            else {
                                if($db->query("UPDATE user SET first_name='$fname', last_name='$lname', role_id=$roleid, address='$address' WHERE user_id='$userid'") === true) {
                                    if($currrole == 1 && $role == 2) { // changed from "guru" to "murid"
                                        $result = $db->query("SELECT * FROM grade WHERE user_id='$userid'");
                                        if(mysqli_num_rows($result) == 0) {
                                            if($db->query("INSERT INTO grade (user_id, nilai_tugas, nilai_uts, nilai_uas) VALUES ('$userid', -1, -1, -1)") === true) {
                                                $updateInfo = new Message("success", "User of " . $userid . " has been updated and switched to 'murid', and inserted an entry to grade table.", "none");
                                            }
                                            else {
                                                $updateInfo = new Message("success", "User of " . $userid . " updated and switched to 'murid', but failed to insert an entry to grade table.", "none");
                                            }
                                        }
                                        else {
                                            $updateInfo = new Message("success", "User of " . $userid . " has been updated and switched to 'murid'.", "none");
                                        }
                                    }
                                    else {
                                        $updateInfo = new Message("success", "User of " . $userid . " has been updated.", "none");
                                    }
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
