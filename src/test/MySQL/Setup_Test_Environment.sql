# use the glyph db
use 'mydb';

# create new users bob, jim, and sally

# SELECT add_user("userid","name");
 
CALL add_user("facebook|1264914366866838");
CALL add_user("google-oauth2|101959085494743689800");
CALL add_user("auth0|57c1102f6f4781ce352cb53a");

CALL edit_user("google-oauth2|101959085494743689800","SearchableHandle", "Bob");

# create channels belonging to each  of the users. the channel ids will be 1,2,3
# the channel id will match the user id for simplicity

# by default, the add_channel method adds the owner to the channel

# an extra channel is created for multi user channel
# testing. it will belong to user 1 and have channel id = 4

# SELECT add_channel("name", ownerid, ispublic);
# SELECT add_channel_membership(userid, channeid);

CALL add_channel("Bob's Channel", "facebook|1264914366866838", false);
CALL add_channel("Jim's Channel", "google-oauth2|101959085494743689800", false);
CALL add_channel("Sally's Channel", "auth0|57c1102f6f4781ce352cb53a", false);

CALL add_channel("Bob and Jim's Shared Channel", "facebook|1264914366866838", true);
CALL add_channel_membership("google-oauth2|101959085494743689800", 4);

CALL add_channel("Sally's Shared Channel", "auth0|57c1102f6f4781ce352cb53a", true);
CALL add_channel_membership("google-oauth2|101959085494743689800", 5);


# create glyphs for each of the users.
# for testing, we are going to add the glyphs to each of the user's private
# channels. those glyphs will have ids of 1,2,3 for simplicity

# then a glyph will be created by Bob and added to him and jim's  shared channel.
# this glyph will have an id of 4.  in theory, sally shouldn't be able
# to see it.

# then sally will create a glyph with id of 5, which will not belong to any
# channel (it is public)

# then jim will also create a glyph in the shared channel between him and bob 
# with a glyph id of 6

# for an ease of imagination, this is where the glyphs will be located

#  20  |             |
#      |             |
#  10  |      5      |     1
#      |             |
#   0  | _____3______2___________            
#      |             |     
# -10  |      6      |      
#      |             |
# -20  |_____________|___________4
#     -20    -10     0     10   20


# SELECT add_glyph(ownerid, "pathtocontent", lat, long);
# SELECT add_glyph_to_channel(glyphid, channelid);

CALL add_glyph("facebook|1264914366866838", "www.glyphwebsite.com/bobsglyph", 10.0, 10.0, 10.0);
CALL add_glyph_to_channel(1, 1);

CALL add_glyph("google-oauth2|101959085494743689800", "www.glyphwebsite.com/jimsglyph", 0.0, 0.0, 10.0);
CALL add_glyph_to_channel(2, 2);

CALL add_glyph("auth0|57c1102f6f4781ce352cb53a", "www.glyphwebsite.com/sallysglyph", -10.0, 0.0, 10.0);
CALL add_glyph_to_channel(3, 3);

CALL add_glyph("facebook|1264914366866838", "www.glyphwebsite.com/bobandjimsglyph", 20.0, -20.0, 10.0);
CALL add_glyph_to_channel(4, 4);

CALL add_glyph("auth0|57c1102f6f4781ce352cb53a", "www.glyphwebsite.com/sallyspublicglyph", -10.0, 10.0, 10.0);

CALL add_glyph("google-oauth2|101959085494743689800", "www.glyphwebsite.com/jimssharedglyph", -10, -10, 10.0);
CALL add_glyph_to_channel(6, 4);
