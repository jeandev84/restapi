https://developer/mozilla.org/en-US/docs/Web/HTTP/Authentication@authentication_schemes
Recommended use "Bearer"

$_SERVER["HTTP_AUTHORIZATION"];

GET http://localhost:8000/api/tasks
Authorization:Bearer abc123
...

$headers = apache_request_headers();