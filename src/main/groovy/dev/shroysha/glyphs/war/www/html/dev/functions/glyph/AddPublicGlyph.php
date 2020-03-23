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

if (empty($postDelay)) {
    $postDelay = $_POST['postDelay'];
}

if (empty($userInfo) or empty($latitude) or empty($longitude) or empty($altitude) or empty($postDelay)) {
    die("field empty");

} else {
    if (!(-90 < $latitude && $latitude < 90 && -180 < $longitude && $longitude < 180)) {
        die("lat long out of range");

    } else {
        $ownerid = $userInfo['user_id'];

        include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
        $database = new MysqlDatabase();

        $database->query("CALL add_public_glyph(:ownerId, :latitude, :longitude, :altitude, :postDelay)");
        $database->bind(":ownerId", $userInfo['user_id']))
        	$database->bind(":latitude", $latitude);
        	$database->bind(":longitude", $longitude);
                $database->bind(":altitude", $altitude);
		$database->bind(":postDelay", $postDelay);

        	$row = $database->single();
		$createdGlyph = new MysqlGlyphData($row);

		echo json_encode($createdGlyph, JSON_PRETTY_PRINT);
	}
}

