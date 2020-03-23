<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($unblockuser)) {
    $unblockuser = $_POST['unblockuser'];
}

if (empty($userInfo) or empty($unblockuser)) {
    # these values are detrimental to the success of the function, and if they aren't filled no action should be taken

    if (empty($userInfo)) echo "User info empty";
    if (empty($unblockuser)) echo "Unblock user empty";

} else {
    $userid = $userInfo['user_id'];

    $command = "CALL stop_blocking_user(\"" . $userid . "\",\"" . $unblockuser . "\");";
    require dirname(__DIR__) . '/mysql/run_mysql_command_no_return.php';

}

