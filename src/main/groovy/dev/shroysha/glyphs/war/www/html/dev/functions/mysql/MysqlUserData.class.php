<?php


class MysqlUserData
{

    public $userId;
    public $searchableHandle;
    public $userAvatarLocation;
    public $dateCreatedTimestamp;

    public function __construct($array)
    {
        $this->userId = $array["userId"];
        $this->searchableHandle = $array["searchableHandle"];
        $this->userAvatarLocation = $array["userAvatarLocation"];
        $this->dateCreatedTimestamp = $array["dateCreatedTimestamp"];
    }

    public static function parse_users($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlUserData($row);
        }

        return $rows;
    }
}
