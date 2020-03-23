<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($handle)) {
    $handle = $_POST['handle'];
}

if (empty($userInfo)) {
    if (empty($userInfo)) echo "User info empty";
    if (empty($handle)) echo "Handle empty";
} else {

    $command = "SELECT handle_taken(\"" . $handle . "\");";
    require dirname(__DIR__) . '/mysql/run_mysql_command.php';
    $handleTaken = $rows[0][0];

    echo $handleTaken;
}
