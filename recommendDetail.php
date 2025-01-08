<?php

include("connect.php");

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  exit('不正なアクセスです');
}

$recommend_id = (int)$_GET['id'];

$sql = "SELECT * FROM recommend WHERE id = :recommend_id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':recommend_id', $recommend_id, PDO::PARAM_INT);
$statement->execute();
$recommend = $statement->fetch(PDO::FETCH_ASSOC);

if (!$recommend) {
  exit('指定されたレコメンドが見つかりません');
}


$sql = "SELECT * FROM posts WHERE recommend_id = :recommend_id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':recommend_id',$recommend_id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>レコメンド投稿</title>
</head>
<body>
  <header>
    <h1 class="title"><a href="top.php">myレコ</a></h1>
  </header>
<body>
<div class="recommendWrapper">

  <div class="titleArea">
              <span>タイトル：</span>
              <p class=""><?php echo $recommend["title"]; ?></p>
              <span>投稿者：</span>
              <p class=""><?php echo $recommend["userName"]; ?></p>
              <time >：<?php echo $recommend["post_date"]; ?></time>
            </div>
  </div>


  <div class="recommend">
    <ol>
      <li><?php echo $recommend["recommend1"]; ?></li>
      <li><?php echo $recommend["recommend2"]; ?></li>
      <li><?php echo $recommend["recommend3"]; ?></li>
    </ol>
  <span>メッセージ：</span>
  <p class=""><?php echo $recommend["message"]; ?></p>
  </div>
</div>
<hr>
  <section>
    <?php foreach ($posts as $post) : ?>
      <article>
        <div class ="wrapper">
            <span>投稿者：</span>
            <p class=""><?php echo $post["userName"]; ?></p>
            <time >：<?php echo $post["created_at"]; ?></time>
            <span>コメント：</span>
            <p class=""><?php echo $post["content"]; ?></p>
        </div>
        <hr>
      </article>
    <?php endforeach ?>
  </section>

</body>
