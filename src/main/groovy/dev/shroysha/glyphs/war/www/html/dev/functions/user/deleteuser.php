<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($confirm)) {
    $confirm = $_POST['confirm'];
}

if (empty($userInfo) or empty($confirm)) {
    if (empty($userInfo)) echo "User info empty";
    if (empty($confirm)) echo "Not confirmed";
} else {
    $userid = $userInfo['user_id'];

    $confirmationOfDelete = "True";
    if (strcmp($confirmationOfDelete, $confirm) != 0) {
        echo "Need confirmation";
    } else {

        $command = "CALL delete_user(\"" . $userid . "\");";
        require dirname(__DIR__) . '/mysql/run_mysql_procedure_no_return.php';

        echo "User " . $userid . " deleted";
    }

}
?>

