<?php


include_once dirname(__DIR__) . '/mysql/MysqlGlyphData.class.php';

class MysqlFoundGlyphData
{

    public $foundGlyphId;
    public $dateFoundTimestamp;
    private $glyphData;

    public function __construct($array)
    {
        $this->glyphData = new MysqlGlyphData($array);
        $this->foundGlyphId = $this->glyphData->glyphId;
        $this->dateFoundTimestamp = $array["dateFoundTimestamp"];
    }

    public static function parse_found_glyphs($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlFoundGlyphData($row);
        }

        return $rows;
    }

    public function get_glyph_data()
    {
        return $this->glyphData;
    }
}
