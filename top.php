<?php
include_once("connect.php");



$recommend_array = array();

$sql = "SELECT * FROM recommend";
$statement = $pdo->prepare($sql);
$statement->execute();

$recommend_array = $statement;

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>myレコ</title>
</head>
<body>
  <header>
    <h1 class="title">myレコ</h1>
  </header>
  <section>
    <?php foreach ($recommend_array as $recommend) : ?>
      <article>
        <div class ="wrapper">
          <div class="titleArea">
            <span>タイトル：</span>
            <p class=""><?php echo $recommend["title"]; ?></p>
            <span>投稿者：</span>
            <p class=""><?php echo $recommend["userName"]; ?></p>
            <time >：<?php echo $recommend["post_date"]; ?></time>
          </div>
        </div>
      </article>
    <?php endforeach ?>
  </section>
</body>
