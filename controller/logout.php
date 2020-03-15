<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        if(isset($_SESSION["uschool-id"]) && isset($_SESSION["uschool-token"])) {
            include "../model/jsonmessage.php";

            session_unset();
            if(!isset($_SESSION["uschool-id"]) && !isset($_SESSION["uschool-token"])) {
                $logoutMsg = new Message("success", "Session data has been unset.", "none");
            }
            else {
                $logoutMsg = new Message("error", "An error occured while unsetting the session.", "none");
            }

            echo json_encode($logoutMsg);
        }
        else echo "<script>window.top.location.href = \"..\"</script>";
    }
    else {
        echo "<script>window.top.location.href = \"..\"</script>";
    }
?>
