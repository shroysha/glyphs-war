#! /bin/sh

# Copyright 2014 Gleetr SAS
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

# Pre-requisite: you need jq - http://stedolan.github.io/jq/
# set -x

CURL_ARGS=$@
# CURL_VERBOSE=-vvv

AUTH0_DOMAIN=shroysha.auth0.com
AUTH0_CLIENTID=ZMBm759muZ6K5sVsg0xdgExZyyMmfidv
AUTH0_USERNAME=shroysha@gmail.com
AUTH0_PASSWORD=sk84life

# AUTH0_SCOPE='openid email'
AUTH0_SCOPE=openid

RO_URL=https://${AUTH0_DOMAIN}/oauth/ro
RO_PAYLOAD="{
   \"client_id\":   \"${AUTH0_CLIENTID}\",
   \"username\":    \"${AUTH0_USERNAME}\",
   \"password\":    \"${AUTH0_PASSWORD}\",
   \"connection\":  \"Username-Password-Authentication\",
   \"grant_type\":  \"password\",
   \"scope\":       \"${AUTH0_SCOPE}\",
   \"device\":      \"\"
}"

# call Auth0 to retrieve the JWT
JWT=$(echo ${RO_PAYLOAD} | curl ${CURL_VERBOSE} -X POST --header 'Content-Type: application/json' --data-binary @- ${RO_URL})
# Result: {"id_token":"xxx.yyy.zzz","access_token":"aaaaaaaaaaaaaaaa","token_type":"bearer"}

echo $JWT
# extract the id_token in the JWT
ID_TOKEN=$(echo ${JWT} | jq -r '.id_token')
