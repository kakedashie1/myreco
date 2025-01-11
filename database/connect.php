<?php

$user ="root";

$pass = "pass";

try {
  $pdo = new PDO('mysql:host=localhost;dbname=myrecommend', $user, $pass);

} catch(PDOException $error) {
  echo $error->getMessage();
}
