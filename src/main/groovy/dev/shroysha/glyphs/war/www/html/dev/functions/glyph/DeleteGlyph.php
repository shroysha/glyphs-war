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

    $database->query("SELECT glyph_get_owner(:glyphId)");
    $database->bind(":glyphId", $glyphId);

    $row = $database->single();
    $ownerId = $row[0];

    if (empty($ownerId)) {
        die("no owner");
    } else {
        if (strcmp($ownerId, $userInfo['user_id']) != 0) {
            die("trying to delete someone elses glyph";
        } else {
            $database->query("CALL delete_glyph(:glyphId)");
            $database->bind(":glyphId", $glyphId);

            $database->execute();
            echo "Success!";
        }
    }
}
