<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($glyphId)) {
    $glyphId = $_POST['glyphid'];
}

if (empty($userComment)) {
    $userComment = $_POST['userComment'];
}

if (empty($userInfo) or empty($glyphId) or empty($userComment)) {
    die("field empty");
} else {
    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();

    $database->query("CALL add_comment_to_glyph(:glyphId, :userId, :userComment)");
    $database->bind(":glyphId", $glyphId);
    $database->bind(":userId", $userInfo['user_id']);
    $database->bind(":userComment", $userComment);

    $row = $database->single();

    include_once dirname(__DIR__) . '/mysql/MysqlCommentData.class.php';
    $createdComment = new MysqlCommentData($row);

    echo json_encode($createdComment, JSON_PRETTY_PRINT);
}

