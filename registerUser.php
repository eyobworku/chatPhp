<?php
session_start();
include("conn.php");
include("links.php");

if (isset($_POST["uName"])) {
    $sql = "INSERT INTO users (User) VALUES('" . $_POST["uName"] . "')";
    if ($con->query($sql))
        header("Location: index.php");

    else
        echo "Error. Please try again.";
}

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<body>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Register your name</h4>
            </div>
            <div class="modal-body">
                <form action="registerUser.php" method="POST">
                    <p>Name</p>
                    <input type="text" name="uName" id="uName" class="form-control" autocomplete="off" />
                    <br>
                    <input type="submit" name="submit" class="btn btn-primary" style="float:right;" value="0K" />
                </form>
            </div>
        </div>
    </div>
</body>

</html>