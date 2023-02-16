<?php
session_start();
include("conn.php");
include("links.php");

if (isset($_GET["userId"])) {
    $_SESSION["userId"] = $_GET["userId"];
    header("location: chatbox.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <titles></titles>
</head>
<div class="modal-dialog">
    <div class="modal-content">

         <div class="modal-header">
            <h4>Please Select Your Account</h4>
        </div>

        <div class="modal-body">
            <ol>
                <?php

                $users = mysqli_query($con, "SELECT * FROM users")

                    or die("Failed to query database" . mysqli_connect_error());
                while ($user = mysqli_fetch_assoc($users)) {

                    echo '<li><a href="index.php?userId=' . $user["id"] . '">' . $user["user"] . '</a></1i>';
                }
                ?>
            </ol>
            <a href="registerUser.php" style="float:right;">Register here.</a>
        </div>
    </div>
</div>
</body>