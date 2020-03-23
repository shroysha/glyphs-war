ID_TOKEN=$(cat ID_TOKEN.txt)

curl --request GET \
  --url "http://ec2-52-40-186-167.us-west-2.compute.amazonaws.com/dev/functions/user/getinfo.php" \
  --header "Authorization: $ID_TOKEN"
