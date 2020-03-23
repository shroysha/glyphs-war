<?php


include_once dirname(__DIR__) . '/mysql/MysqlGlyph.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlFriendData.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlOwnedGlyphData.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlFoundGlyphData.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlSharedGlyphData.class.php';
include_once dirname(__DIR__) . '/mysql/MysqlExtendedGlyphData.class.php';

class MysqlLoggedInUser
{

    public $userId;
    public $searchableHandle;
    public $userAvatarLocation;
    public $dateCreatedTimestamp;

    public $friends;
    public $ownedGlyphs;
    public $foundGlyphs;
    public $sharedWithUserGlyphs;

    public $glyphCache;
    public $userCache;

    private $userData;

    public function __construct($userInfo)
    {
        $this->userId = $userInfo['user_id'];
        $this->userAvatarLocation = $userInfo['picture'];
    }

    public function does_user_exist_in_database($database)
    {
        $database->query("SELECT user_exists(:userId)");
        $database->bind(":userId", $this->userId);

        $row = $database->single();

        return array_values($row)[0];
    }

    public function create_user_in_database($avatarLocation, $database)
    {
        $database->query("CALL add_user(:userid, :avatarLocation)");
        $database->bind(":userId", $this->userId);
        $database->bind(":avatarLocation", $this->recentAvatarLocation);

        $database->execute();
    }

    public function extract_user_profile($database)
    {
        $this->extract_user_info($database);
        $this->extract_users_friends($database);
        $this->extract_users_owned_glyphs($database);
        $this->extract_users_found_glyphs($database);
        $this->extract_glyphs_shared_with_user($database);
    }

    private function extract_user_info($database)
    {
        $database->query("CALL get_user_info (:userId)");
        $database->bind(":userId", $this->userId);

        $row = $database->single();
        $this->userId = $row["userId"];
        $this->searchableHandle = $row["searchableHandle"];
        $this->userAvatarLocation = $row["userAvatarLocation"];
        $this->dateCreatedTimestamp = $row["dateCreatedTimestamp"];

        $this->userData = new MysqlUserData($row);
    }

    private function extract_users_friends($database)
    {
        $database->query("CALL get_all_friendships(:userId)");
        $database->bind(":userId", $this->userId);

        $rows = $database->resultset();
        $this->friends = MysqlFriendData::parse_friendships($rows);

        $this->add_friends_to_user_cache($this->friends);
    }

    private function add_friends_to_user_cache($friends)
    {
        if (empty($this->userCache)) {
            $this->userCache = array();
        }

        foreach ($friends as $friend) {
            if (!in_array($friend->get_to_user_data(), $this->userCache)) {
                $this->userCache[] = $friend->get_to_user_data();
            }
            if (!in_array($friend->get_from_user_data(), $this->userCache)) {
                $this->userCache[] = $friend->get_from_user_data();
            }
        }
    }

    private function extract_users_owned_glyphs($database)
    {
        $database->query("CALL get_owned_glyphs(:userId)");
        $database->bind(":userId", $this->userId);

        $rows = $database->resultset();
        $this->ownedGlyphs = MysqlOwnedGlyphData::parse_owned_glyphs($rows);

        $this->add_glyphs_to_glyph_cache($this->ownedGlyphs);
    }

    private function add_glyphs_to_glyph_cache($glyphs)
    {
        if (empty($this->glyphCache)) {
            $this->glyphCache = array();
        }

        foreach ($glyphs as $glyph) {
            if (!in_array($glyph->get_glyph_data(), $this->glyphCache)) {
                $this->glyphCache[] = $glyph->get_glyph_data();
            }
        }
    }

    private function extract_users_found_glyphs($database)
    {
        $database->query("CALL get_found_glyphs(:userId)");
        $database->bind(":userId", $this->userId);

        $rows = $database->resultset();
        $this->foundGlyphs = MysqlFoundGlyphData::parse_found_glyphs($rows);

        $this->add_glyphs_to_glyph_cache($this->foundGlyphs);
        $this->add_glyph_owners_to_user_cache($this->foundGlyphs);
    }

    private function add_glyph_owners_to_user_cache($glyphs)
    {
        if (empty($this->glyphCache)) {
            $this->glyphCache = array();
        }

        foreach ($glyphs as $glyph) {
            if (!in_array($glyph->get_glyph_data()->get_owner_data(), $this->userCache)) {
                $this->userCache[] = $glyph->get_glyph_data()->get_owner_data();
            }
        }
    }

    private function extract_glyphs_shared_with_user($database)
    {
        $database->query("CALL get_glyphs_shared_with_user(:userId)");
        $database->bind(":userId", $this->userId);

        $rows = $database->resultset();
        $this->sharedWithUserGlyphs = MysqlSharedGlyphData::parse_shared_glyphs($rows);

        $this->add_glyphs_to_glyph_cache($this->sharedWithUserGlyphs);
        $this->add_glyph_owners_to_user_cache($this->sharedWithUserGlyphs);
    }
}
