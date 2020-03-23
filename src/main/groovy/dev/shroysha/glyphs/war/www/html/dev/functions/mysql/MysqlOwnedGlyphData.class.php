<?php


include_once dirname(__DIR__) . '/mysql/MysqlGlyphData.class.php';

class MysqlOwnedGlyphData
{

    public $ownedGlyphId;
    public $dateCreatedTimestamp;
    private $glyphData;

    public function __construct($array)
    {
        $this->glyphData = new MysqlGlyphData($array);
        $this->ownedGlyphId = $this->glyphData->glyphId;
        $this->dateCreatedTimestamp = $array["dateCreatedTimestamp"];
    }

    public static function parse_owned_glyphs($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlOwnedGlyphData($row);
        }

        return $rows;
    }

    public function get_glyph_data()
    {
        return $this->glyphData;
    }
}
