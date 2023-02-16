<?php
session_start();
include("conn.php");
include("links.php");
if (!isset($_SESSION["userId"])) {
    header("location: index.php");
}
$users = mysqli_query($con, "SELECT * FROM users WHERE id = '" . $_SESSION["userId"] . "' ")
    or die("Failed to query database" . mysqli_connect_error());
$user = mysqli_fetch_assoc($users);
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <p>Hi <?php echo $user["user"]; ?> </p>
                <input type="text" id="fromUser" value=<?php echo $user["id"]; ?> hidden />

                <p>Send message to:</p>

                <ul>
                    <?php
                    $msgs = mysqli_query($con, "SELECT * FROM users")
                        or die("Failed to query database" . mysqli_connect_error());
                    while ($msg = mysqli_fetch_assoc($msgs)) {
                        echo '<li><a href="?toUser=' . $msg["id"] . '">' . $msg["user"] . '</a></1i>';
                    }
                    ?>
                </ul>
                <a href="index.php"><-- Back</a>
            </div>
            <div class="col-md-4">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>

                                <?php
                                if (isset($_GET["toUser"])) {

                                    $userName = mysqli_query($con, "SELECT * FROM users WHERE id = '" . $_GET["toUser"] . "' ")
                                        or die("Failed to query database" . mysqli_connect_error());

                                    $uName = mysqli_fetch_assoc($userName);
                                    if($uName){
                                    $_SESSION["toUser"] = $_GET["toUser"];
                                    echo '<input type="text" id="toUser" value="' . $_GET["toUser"] . '" hidden/>';

                                    echo $uName["user"];
                                    }
                                } else {
                                    $userName = mysqli_query($con, "SELECT * FROM users")
                                        or die("Failed to query database" . mysqli_connect_error());
                                    $uName = mysqli_fetch_assoc($userName);
                                    $_SESSION["toUser"] = $uName["id"];
                                    echo '<input type="text" id="toUser" value="' . $_SESSION["toUser"] . '" hidden/>';
                                    echo $uName["user"];
                                }
                                ?>
                            </h4>
                        </div>
                        <div class="modal-body" id="msgBody" style="height:400px; overflow-y: scroll; overflow-x: hidden;">
                            <?php
                            if (isset($_GET["toUser"]))
                                $chats = mysqli_query($con, "SELECT * FROM messages where (FromUser = '" . $_SESSION["userId"] . "' AND 
 ToUser = '" . $_GET["toUser"] . "') OR (FromUser = '" . $_GET["toUser"] . "' AND ToUser = '" . $_SESSION["userId"] . "')")
                                    or die("Failed to query database" . mysqli_connect_error());
                            else
                                $chats = mysqli_query($con, "SELECT * FROM messages where (FromUser = '" . $_SESSION["userId"] . "' AND 
ToUser = '" . $_SESSION["toUser"] . "') OR (FromUser = '" . $_SESSION["toUser"] . "' AND ToUser = '" . $_SESSION["userId"] . "')")
                                    or die("Failed to query database" . mysqli_connect_error());
                            while ($chat = mysqli_fetch_assoc($chats)) {
                                if ($chat["FromUser"] == $_SESSION["userId"])
                                    echo "<div style='text-align:right;'>
                              <p style='background-color:lightblue; word-wrap:break-word; display:inline-block;
                                  padding:5px; border-radius:10px; max width:70%;'>
                                  " . $chat["message"] . "
                              </p>
                    </div>";
                                else
                                    echo "<div style='text-align:left;'>
                              <p style='background-color:yellow; word-wrap:break-word; display:inline-block;
                                  padding:5px; border-radius:10px; max width:70%;'>
                                                " . $chat["message"] . "
                              </p>
                              </div>";
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <textarea id="message" class="form-control" style="height:70px;"></textarea>
                            <button id="send" class="btn btn-primary" style="height: 70%;">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $("#send").on("click", function() {
            $.ajax({
                url: "insertMessage.php",
                method: "POST",
                data: {
                    fromUser: $("#fromUser").val(),
                    toUser: $("#toUser").val(),
                    message: $("#message").val()
                },
                dataType: "text",
                success: function(data) {
                    $("#message").val("");
                }
            });
        });

        setInterval(function() {

            $.ajax({
                url: "realTimeChat.php",
                method: "POST",
                data: {
                    fromUser: $("#fromUser").val(),
                    toUser: $("#toUser").val()
                },
                dataType: "text",
                success: function(data) {
                    $('#msgBody').html(data);
                }
            });
        }, 700);
    });
</script>

</html>