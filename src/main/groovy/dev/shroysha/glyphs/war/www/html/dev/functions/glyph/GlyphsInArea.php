<?php


if (empty($bottomLeftLatitude)) {
    $bottomLeftLatitude = $_POST['bottomLeftLatitude'];
}

if (empty($bottomLeftLongitude)) {
    $bottomLeftLongitude = $_POST['bottomLeftLongitude'];
}

if (empty($topRightLatitude)) {
    $topRightLatitude = $_POST['topRightLatitude'];
}

if (empty($topRightLongitude)) {
    $topRightLongitude = $_POST['topRightLongitude'];
}

if (empty($bottomLeftLatitude) or empty($bottomLeftLongitude) or empty($topRightLatitude) or empty($topRightLongitude)) {
    die("Field empty");
} else {
    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();

    $database->query("CALL glyphs_in_area(:bottomLeftLatitude, :bottomLeftLongitude, :topRightLatitude, :topRightLongitude)");
    $database->bind(":bottomLeftLatitude", $bottomLeftLatitude);
    $database->bind(":bottomLeftLongitude", $bottomLeftLongitude);
    $database->bind(":topRightLatitude", $topRightLatitude);
    $database->bind(":topRightLongitude", $topRightLongitude);

    $rows = $database->resultset();

    include_once dirname(__DIR__) . '/mysql/MysqlGlyphData.class.php';
    $glyphsInArea = MysqlGlyphData::parse_glyphs($rows);

    echo json_encode($glyphsInArea, JSON_PRETTY_PRINT);
}
