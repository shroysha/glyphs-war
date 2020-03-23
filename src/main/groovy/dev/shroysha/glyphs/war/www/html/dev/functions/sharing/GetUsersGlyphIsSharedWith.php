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

    $database->query("CALL get_all_share_events(:glyphId)");
    $database->bind(":glyphId", $glyphId);

    $rows = $database->resultset();

    include_once dirname(__DIR__) . '/mysql/MysqlUserSharedGlyphData.class.php';
    $shares = MysqlUserSharedGlyphData::parse_shares($rows);

    $sharesList = new StdClass();
    $sharesList->sharedWith = $shares;

    echo json_encode($sharesList, JSON_PRETTY_PRINT);
}
