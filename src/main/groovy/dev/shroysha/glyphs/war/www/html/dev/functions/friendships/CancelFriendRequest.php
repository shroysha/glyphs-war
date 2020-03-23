<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($toUser)) {
    $toUser = $_POST['toUser'];
}

if (empty($userInfo) or empty($toUser)) {
    die("field empty");
} else {
    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();

    $database->query("CALL cancel_friend_request(:fromUser, :toUser)");
    $database->bind(":fromUser", $userInfo['user_id']);
    $database->bind(":toUser", $toUser);
    $database->execute();

    echo "Success!";
}

