<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($blockuser)) {
    $blockuser = $_POST['blockuser'];
}

if (empty($userInfo) or empty($blockuser)) {
    # these values are detrimental to the success of the function, and if they aren't filled no action should be taken

    if (empty($userInfo)) echo "User info empty";
    if (empty($blockuser)) echo "Block user empty";

} else {

    $userid = $userInfo['user_id'];
    $command = "CALL start_blocking_user(\"" . $userid . "\",\"" . $blockuser . "\");";
    require dirname(__DIR__) . '/mysql/run_mysql_command.php';

    foreach ($rows as $row) {
        print_r($row);
    }
}

