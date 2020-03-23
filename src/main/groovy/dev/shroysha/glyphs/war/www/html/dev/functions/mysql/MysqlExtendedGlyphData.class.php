<?php


include_once dirname(__DIR__) . '/mysql/MysqlCommentData.class.php';

class MysqlExtendedGlyphData
{

    public $glyphData;
    public $comments;
    public $glyphSharedEvents;
    private $shouldGetComments;
    private $shouldGetShares;

    public function __construct($glyphData, $shouldGetComments, $shouldGetShares)
    {
        $this->glyphData = $glyphData;
        $this->shouldGetComments = $shouldGetComments;
        $this->shouldGetShares = $shouldGetShares;
    }

    public function extract_glyph_data($database)
    {
        if ($this->shouldGetComments) {
            $this->extract_glyph_comments($database);
        }

        if ($this->shouldGetShares) {
            $this->extract_glyph_shares($database);
        }
    }

    public function extract_glyph_comments($database)
    {
        $database->query("CALL get_all_comments(:glyphId)");
        $database->bind(":glyphId", $this->glyphData->glyphId);

        $rows = $database->resultset();

        $this->comments = MysqlCommentData::parse_comments($rows);
    }

    public function extract_glyph_shares($database)
    {
        $database->query("CALL get_all_share_events(:glyphId)");
        $database->bind(":glyphId", $this->glyphData->glyphId);

        $rows = $database->resultset();

        $this->glyphSharedEvents = MysqlSharedGlyphData::parse_shared_glyphs($rows);
    }
}
