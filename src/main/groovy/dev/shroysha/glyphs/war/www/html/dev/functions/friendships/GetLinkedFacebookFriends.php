<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($userInfo)) {
    die("field empty");
} else {
    $fbFriends = array();

    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();
    include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';

    $mutualFriends = $userInfo['context']['mutual_friends']['data'];
    foreach ($mutualFriends as $friend) {
        $friendUserId = facebook | " . $friend['id'];

		$database->query("CALL get_user_info(:userId)");
		$database->bind(":userId", $friendUserId);

		$fbFriends[] = new MysqlUserData($database->single());
	}

	echo json_encode($fbFriends, JSON_PRETTY_PRINT);
}

