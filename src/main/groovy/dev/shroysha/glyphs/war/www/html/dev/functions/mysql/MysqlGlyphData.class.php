<?php


include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';

class MysqlGlyphData
{

    public $glyphId;
    public $glyphIsPublic;
    public $glyphPostDelay;
    public $gpsLocation;

    public $ownerUserId;
    private $ownerData;

    public function __construct($array)
    {
        $this->glyphId = $array["glyphId"];
        $this->glyphIsPublic = $array["glyphIsPublic"];
        $this->glyphPostDelay = $array["glyphPostDelay"];
        $this->gpsLocation = $this->extract_gps_field($array);
        $this->ownerData = new MysqlUserData($array);
        $this->ownerUserId = $this->ownerData->userId;
    }

    private function extract_gps_field($row)
    {
        $gpsLoc = array();

        $gpsLoc["latitude"] = $row["glyphLatitude"];
        $gpsLoc["longitude"] = $row["glyphLongitude"];
        $gpsLoc["altitude"] = $row["glyphAltitude"];

        return $gpsLoc;
    }

    public static function parse_glyphs($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlGlyphData($row);
        }

        return $rows;
    }

    public function get_owner_data()
    {
        return $this->ownerData;
    }
}
