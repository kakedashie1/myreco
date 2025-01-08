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
    <h1 class="title"><a href="top.php">myレコ</a></h1>
    <h2 class="register"><a href="createRecommend.php">レコメンドを投稿する</a></h2>
  </header>
  <section>
    <?php foreach ($recommend_array as $recommend) : ?>
      <article>
        <div class ="wrapper">
          <div class="titleArea">
            <span>タイトル：</span>
            <p class=""><a href="recommendDetail.php?id=<?php echo $recommend['id']; ?>"><?php echo $recommend["title"]; ?></a></p>
            <span>投稿者：</span>
            <p class=""><?php echo $recommend["userName"]; ?></p>
            <time >：<?php echo $recommend["post_date"]; ?></time>
          </div>
        </div>
        <hr>
      </article>
    <?php endforeach ?>
  </section>
</body>
