<?php


require dirname(__DIR__) . '/auth0/load-user.php';

if (empty($commentid)) {
    $commentid = $_POST['commentid'];
}

if (empty($userInfo) or empty($commentid)) {
    # these values are detrimental to the success of the function, and if they aren't filled no action should be taken

    if (empty($userInfo)) echo "User info empty";
    if (empty($commentid)) echo "Comment ID empty";

} else {

    $command = "CALL delete_comment_from_glyph(" . $commentid . ");";
    require dirname(__DIR__) . '/mysql/run_mysql_command_no_return.php';

}

