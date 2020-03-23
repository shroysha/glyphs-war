<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($glyphId)) {
    $glyphId = $_POST['glyphid'];
}

if (empty($userInfo) or empty($glyphId)) {
    die("field empty");
} else {
    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();

    $database->query("CALL get_all_comments(:glyphId)");
    $database->bind(":glyphId", $glyphId);

    $rows = $database->resultset();

    include_once dirname(__DIR__) . '/mysql/MysqlCommentData.class.php';
    $comments = MysqlCommentData::parse_comments($rows);

    $commentList = new StdClass();
    $commentList->comments = $comments;

    echo json_encode($commentList, JSON_PRETTY_PRINT);
}

