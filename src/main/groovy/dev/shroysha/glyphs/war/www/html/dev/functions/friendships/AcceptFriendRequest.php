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

    $database->query("CALL accept_friend_request(:fromUser, :toUser)");
    $database->bind(":fromUser", $fromUser);
    $database->bind(":toUser", $userInfo['user_id']);

    $row = $database->single();
    $newFriend = new MysqlFriendData($row);

    echo json_encode($newFriend, JSON_PRETTY_PRINT);
}

