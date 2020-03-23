<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($latitude)) {
    $latitude = $_POST['latitude'];
}

if (empty($longitude)) {
    $longitude = $_POST['longitude'];
}

if (empty($altitude)) {
    $altitude = $_POST['altitude'];
}


if (empty($userInfo) or empty($latitude) or empty($longitude) or empty($altitude)) {
    die("field empty");
} else {
    if (!(-90 < $latitude && $latitude < 90 && -180 < $longitude && $longitude < 180)) {
        die("lat or long out of range");
    } else {
        include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
        $database = new MysqlDatabase();

        $database->query("CALL add_private_glyph(:ownerId, :latitude, :longitude, :altitude)");
        $database->bind(":ownerId", $userInfo['user_id']))
        	$database->bind(":latitude", $latitude);
        	$database->bind(":longitude", $longitude);
                $database->bind(":altitude", $altitude);

        	$row = $database->single();
		$createdGlyph = new MysqlGlyphData($row);

		echo json_encode($createdGlyph, JSON_PRETTY_PRINT);
	}
}

