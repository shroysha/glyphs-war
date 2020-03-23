<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($glyphId)) {
    $glyphId = $_POST['glyphid'];
}

if (empty($userSharedWith)) {
    $userSharedWith = $_POST['usersharedwith'];
}

if (empty($userInfo) or empty($glyphId) or empty($userSharedWith)) {
    die("field empty");
} else {
    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();

    $database->query("CALL stop_sharing_glyph(:glyphId, :userId)");
    $database->bind(":glyphId", $glyphId);
    $database->bind(":userId", $userSharedWith);

    $database->execute();
}

