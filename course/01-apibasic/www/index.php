<?php

/*
$response = file_get_contents("https://randomuser.me/api");
echo $response ."\n";
$response = file_get_contents("https://example.com");
echo $response;
==============================================================================
JSON - Javascript Object Notation
https://www/json.org/json-en.html
https://www.php.net/manual/en/function.json-decode.php
https://api.agify.io/?name=michael

====================== Example ======================================
$response = file_get_contents("https://randomuser.me/api");
$data = json_decode($response, true);
print_r($data);
echo $data["results"][0]["name"]["first"], "\n";
*/

if (! empty($_GET["name"])) {
    $response = file_get_contents("https://api.agify.io?name={$_GET['name']}");
    $data = json_decode($response, true);
    $age   = $data["age"];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Example</title>
</head>
<body>
  <?php if (isset($age)): ?>
      Age : <?= $age ?>
  <?php endif; ?>
  <form action="">
      <label for="">Name
          <input type="text" name="name" id="name">
      </label>
      <button>Guess age</button>
  </form>
</body>
</html>
