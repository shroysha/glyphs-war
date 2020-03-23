<?php


include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';

class MysqlCommentData
{

    public $commentId;
    public $usersComment;
    public $commentedBy;
    public $dateCommentedTimestamp;

    public function __construct($array)
    {
        $this->commentId = $array["commentId"];
        $this->usersComment = $array["usersComment"];
        $this->commentedBy = new MysqlUserData($array);
        $this->dateCommentedTimestamp = $array["dateCommentedTimestamp"];
    }

    public static function parse_comments($rows)
    {
        foreach ($rows as $key => $row) {
            $rows[$key] = new MysqlCommentData($row);
        }

        return $rows;
    }

}
