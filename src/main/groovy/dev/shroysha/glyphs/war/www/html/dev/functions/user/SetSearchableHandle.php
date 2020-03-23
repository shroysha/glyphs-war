<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($handle)) {
    $handle = $_POST['handle'];
}

if (empty($userInfo)) {
    if (empty($userInfo)) echo "User info empty";
    if (empty($handle)) echo "Handle empty";
} else {
    $userid = $userInfo['user_id'];

    if (strcmp($userid, $handle) !== 0) {
        require "IsHandleTaken.php";
    } else {
        $handleTaken = FALSE;
    }

    if ($handleTaken) {
        echo "Handle taken";
    } else {
        $command = "CALL set_handle(\"" . $userid . "\",\"" . $handle . "\");";
        require dirname(__DIR__) . '/mysql/run_mysql_command_no_return.php';

        echo "Success";
    }
}
?>
