# Create users

call add_user("facebook|1909463769082263", "https://scontent.xx.fbcdn.net/v/t1.0-1/11149488_1136909596337688_3751353330705341780_n.jpg?oh=cd54732ced3f0a8441258de3bcf792e2&oe=5AD6CE81");
call add_user("facebook|1751101561581447", "https://scontent.xx.fbcdn.net/v/t1.0-1/18118644_1535527509805521_6264329128581734938_n.jpg?oh=4048fc9ba6cc24e1d478bcef90e81586&oe=5A8F5F99");
call add_user("auth0|57b9fed1a1f94dcf4eab88ac","https://s.gravatar.com/avatar/81d799e7f249b8dd0fc4771b8438bb4c?s=480&r=pg&d=https%3A%2F%2Fcdn.auth0.com%2Favatars%2Fll.png");
call add_user("google-oauth2|101959085494743689800","https://lh3.googleusercontent.com/-lepg5Qi4wBk/AAAAAAAAAAI/AAAAAAAAG5k/XVAMYjME-T8/photo.jpg");

# facebook|1751101561581447 - Me
# Send request to google-oauth2|101959085494743689800
# Receive request from auth0|57b9fed1a1f94dcf4eab88ac
# Add friend facebook|1909463769082263

call send_friend_request("facebook|1751101561581447", "google-oauth2|101959085494743689800");
call send_friend_request("auth0|57b9fed1a1f94dcf4eab88ac","facebook|1751101561581447");
call send_friend_request("facebook|1751101561581447","facebook|1909463769082263");
call accept_friend_request("facebook|1909463769082263","facebook|1751101561581447");

call set_handle("facebook|1751101561581447", "Jazz Hands");
call set_handle("auth0|57b9fed1a1f94dcf4eab88ac", "bob");

call add_private_glyph("facebook|1751101561581447", "facebook|1751101561581447/0/CanvasTexture.png ", 39.48072186, -77.71274826, 0);
call add_private_glyph("facebook|1751101561581447", "facebook|1751101561581447/1/CanvasTexture.png", 39.48070283, -77.71273139, 0);
call add_private_glyph("facebook|1751101561581447", "facebook|1751101561581447/2/CanvasTexture.png ", 39.48070283, -77.71273139, 0);
call add_private_glyph("facebook|1751101561581447", "facebook|1751101561581447/3/CanvasTexture.png ", 39.41409197, -77.80958458, 0);
call add_private_glyph("facebook|1751101561581447", "facebook|1751101561581447/4/CanvasTexture.png", 39.41409352, -77.80962306, 0);

call start_sharing_glyph(4, "auth0|57b9fed1a1f94dcf4eab88ac");
call user_found_glyph("facebook|1751101561581447", 4);
call add_comment_to_glyph(4, "facebook|1751101561581447", "this glyph is really cool!");

call add_user("testblock", "https://lh3.googleusercontent.com/-lepg5Qi4wBk/AAAAAAAAAAI/AAAAAAAAG5k/XVAMYjME-T8/photo.jpg");
call start_blocking_user("facebook|1751101561581447", "testblock");

