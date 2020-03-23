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

    $database->query("CALL user_found_glyph(:userId, :glyphId)");
    $database->bind(":userId", $userInfo['user_id']))
        $database->bind(":glyphId", $glyphId);

        $row = $database->single();
	$foundGlyph = new MysqlFoundGlyphData($row);

	echo json_encode($foundGlyph, JSON_PRETTY_PRINT);
}
