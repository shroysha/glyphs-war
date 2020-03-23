<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($search)) {
    $search = $_POST['search'];
}

if (empty($search) or empty($userInfo)) {
    die("field empty");
} else {
    include_once dirname(__DIR__) . '/mysql/MysqlDatabase.class.php';
    $database = new MysqlDatabase();

    $database->query("CALL search_for_user(%:search %)");
    $database->bind(":search", $search);

    $rows = $database->resultset();

    include_once dirname(__DIR__) . '/mysql/MysqlUserData.class.php';
    $users = MysqlUserData::parse_users($rows);

    echo($users);
}
