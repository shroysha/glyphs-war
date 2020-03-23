<?php


include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlGlyphData.class.php';

class MysqlUserSharedGlyphData
{

    public $userSharedWith;
    public $dateSharedTimestamp;
    private $glyphData;
    private $ownerData;

    public function __construct($array)
    {
        $this->glyphData = new MysqlGlyphData($array);
        $this->ownerData = new MysqlUserData($array);
        $this->userSharedWith = new MysqlUserData($this->extract_shared_with($array));
        $this->dateSharedTimestamp = $array["dateSharedTimestamp"];
    }

    private function extract_shared_with($row)
    {
        $toUser = array();

        $toUser["userId"] = $row["sharedWithUserId"];
        $toUser["searchableHandle"] = $row["sharedWithSearchableHandle"];
        $toUser["dateCreatedTimestamp"] = $row["sharedWithDateCreatedTimestamp"];
        $toUser["userAvatarLocation"] = $row["sharedWithAvatarLocation"];

        return $toUser;
    }

    public static function parse_shares($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlUserSharedGlyphData($row);
        }

        return $rows;
    }

}
