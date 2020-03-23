<?php


include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';

class MysqlFriendData
{

    public $toUserId;
    public $fromUserId;
    public $dateSentTimestamp;
    public $dateAcceptedTimestamp;
    private $toUserData;
    private $fromUserData;

    public function __construct($array)
    {
        $this->toUserData = new MysqlUserData($this->extract_to_user($array));
        $this->fromUserData = new MysqlUserData($this->extract_from_user($array));
        $this->toUserId = $this->toUserData->userId;
        $this->fromUserId = $this->fromUserData->userId;


        $this->dateSentTimestamp = $array["dateSentTimestamp"];
        $this->dateAcceptedTimestamp = $array["dateAcceptedTimestamp"];
    }

    private function extract_to_user($row)
    {
        $toUser = array();

        $toUser["userId"] = $row["toUserId"];
        $toUser["searchableHandle"] = $row["toSearchableHandle"];
        $toUser["dateCreatedTimestamp"] = $row["toDateCreatedTimestamp"];
        $toUser["userAvatarLocation"] = $row["toUserAvatarLocation"];

        return $toUser;
    }

    private function extract_from_user($row)
    {
        $fromUser = array();

        $fromUser["userId"] = $row["fromUserId"];
        $fromUser["searchableHandle"] = $row["fromSearchableHandle"];
        $fromUser["dateCreatedTimestamp"] = $row["fromDateCreatedTimestamp"];
        $fromUser["userAvatarLocation"] = $row["fromUserAvatarLocation"];

        return $fromUser;
    }

    public static function parse_friendships($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlFriendData($row);
        }

        return $rows;
    }

    public function get_to_user_data()
    {
        return $this->toUserData;
    }

    public function get_from_user_data()
    {
        return $this->fromUserData;
    }
}
