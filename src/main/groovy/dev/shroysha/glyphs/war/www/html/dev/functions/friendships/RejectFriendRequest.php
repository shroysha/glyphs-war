<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($fromUser)) {
    $fromUser = $_POST['fromUser'];
}

if (empty($userInfo) or empty($fromUser)) {
    die("field empty");
} else {
    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();

    $database->query("CALL reject_friend_request(:toUser, :fromUser)");
    $database->bind(":toUser", $userInfo['user_id']);
    $database->bind(":fromUser", $fromUser);
    $database->execute();

    echo "Success!"
}

