<?php


include_once dirname(__DIR__) . '/mysql/MysqlGlyphData.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';

class MysqlSharedGlyphData
{

    public $sharedGlyphId;
    public $dateSharedTimestamp;
    private $sharedGlyphData;

    public function __construct($array)
    {
        $this->glyphData = new MysqlGlyphData($array);
        $this->dateSharedTimestamp = $array["dateSharedTimestamp"];
    }

    public static function parse_shared_glyphs($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlSharedGlyphData($row);
        }

        return $rows;
    }

    public function get_glyph_data()
    {
        return $this->sharedGlyphData;
    }
}
