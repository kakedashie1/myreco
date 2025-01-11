<?php

include("../database/connect.php");

if (!isset($_GET['post_id']) || !ctype_digit($_GET['post_id'])) {
  exit('不正なアクセスです');
}

if (!isset($_GET['recommend_id']) || !ctype_digit($_GET['recommend_id'])) {
  exit('不正なアクセスです');
}

$post_id = (int)$_GET['post_id'];
$recommend_id = (int)$_GET['recommend_id'];



$sql = "SELECT * FROM posts WHERE id = :post_id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':post_id',$post_id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch(PDO::FETCH_ASSOC);


if (!$post) {
  exit('指定されたコメントが見つかりません');
}


$sql = "SELECT * FROM comment WHERE post_id = :post_id";
$statement = $pdo->prepare($sql);
$statement->bindValue(':post_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchALL(PDO::FETCH_ASSOC);



$error_message = array();

if(isset($_POST["submitButton"])) {

  if(empty($_POST["userName"])) {
    $error_message["userName"] ="名前を入力してください";
  } else {
    $escaped["userName"] = htmlspecialchars($_POST["userName"], ENT_QUOTES, "UTF-8");
  }

  if(empty($_POST["content"])) {
    $error_message["content"] ="  コメントを入力してください。";
  } else {
    $escaped["content"] = htmlspecialchars($_POST["content"], ENT_QUOTES, "UTF-8");
  }

if(empty($error_message)) {

  $post_date = date("Y-m-d H:i:s");

  $sql = "INSERT INTO `comment` (`post_id`, `userName`, `content`,`comment_date`) VALUES (:post_id, :userName,:content,:comment_date);";

  $statement = $pdo->prepare($sql);

  $statement->bindParam(":post_id",$post_id,PDO::PARAM_INT);

  $statement->bindParam(":userName", $escaped["userName"],PDO::PARAM_STR);

  $statement->bindParam(":comment_date", $post_date,PDO::PARAM_STR);

  $statement->bindParam(":content", $escaped["content"],PDO::PARAM_STR);


  $statement->execute();

  header("Location: comment.php?post_id=" . $post_id . "&recommend_id=" . $recommend_id);

  exit;

}

}



?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="../css/detail.css">
  <link rel="stylesheet" href="smart.css">
  <title>返信</title>
</head>
<body>
  <header class="header">
    <div class="header-logo">

      <h1 class="title"><a href="index.php">myレコ</a></h1>
    </div>
  </header>


<div class="recommendWrapper">
 <div class="recommendArea">


  <div class="titleArea">

              <span>投稿者：</span>
              <p class=""><?php echo $post["userName"]; ?></p>
              <time >：<?php echo $post["created_at"]; ?></time>
  </div>
  </div>


  <div class="recommend">

  <span>メッセージ：</span>
  <p class=""><?php echo $post["content"]; ?></p>
  </div>
</div>
</div>
<hr>
<h3>コメントを書き込む</h3>
<form action="comment.php?post_id=<?php echo $post_id; ?>&recommend_id=<?php echo $recommend_id; ?>" class="commentForm" method="POST">

    <span>名前：</span>
    <input type="text" name="userName">
    <span>コメント：</span>
    <textarea name="content"></textarea>
    <input type="submit" name="submitButton" value="書き込む">


</form>
<?php if(isset($error_message)) : ?>
  <ul class="errorMessage">
    <?php foreach($error_message as $error) : ?>
      <li><?php echo $error ?></li>

    <?php endforeach;?>

  </ul>
<?php endif; ?>
<hr>
  <section>
    <?php foreach ($comments as $comment) : ?>
      <article>
        <div class ="creatorWrapper">
            <span>投稿者：</span>
            <p class=""><?php echo $comment["userName"]; ?></p>
            <time >：<?php echo $comment["comment_date"]; ?></time>
          </div>
            <span>コメント：</span>
            <p class=""><?php echo $comment["content"]; ?></p>
            <hr>
          </article>
          <?php endforeach ?>
          <a href="./recommendDetail.php?id=<?php echo $recommend_id; ?>">戻る</a>
  </section>

</body>
