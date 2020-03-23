<?php


include dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
include dirname(__DIR__) . '/mysql/MysqlLoggedInUser.class.php';

/*
	Print order:
		populateUsersInfo
		populateUsersFriends
		populateUsersOwnedGlyphs
			comments
			shares
		populateUsersFoundGlyphs
			comments
		populateGlyphsSharedWithLoggedInUser
			comments
*/

require dirname(__DIR__) . '/auth0/load-user.php';

if (!empty($userInfo)) {
    print_full_user_profile($userInfo);
} else {
    print("No user info");
}


function print_full_user_profile($userInfo)
{
    $database = new MysqlDatabase();

    $user = new MysqlLoggedInUser($userInfo);
    $user->extract_user_profile($database);

    echo json_encode($user, JSON_PRETTY_PRINT);
}

