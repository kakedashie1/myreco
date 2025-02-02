<?php

include("../database/connect.php");

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


$sql = "SELECT
    p.*,
    IFNULL(c.comments_count, 0) AS comments_count
FROM
    posts p
LEFT JOIN (
    SELECT
        post_id,
        COUNT(*) AS comments_count
    FROM
        comment
    GROUP BY
        post_id
) c ON p.id = c.post_id
WHERE
    p.recommend_id = :recommend_id
ORDER BY
    p.created_at ASC";



$statement = $pdo->prepare($sql);
$statement->bindValue(':recommend_id',$recommend_id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);




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

  $sql = "INSERT INTO `posts` (`recommend_id`, `userName`, `content`,`created_at`) VALUES (:recommend_id, :userName,:content,:created_at);";

  $statement = $pdo->prepare($sql);

  $statement->bindParam(":recommend_id",$recommend_id,PDO::PARAM_STR);

  $statement->bindParam(":userName", $escaped["userName"],PDO::PARAM_STR);

  $statement->bindParam(":created_at", $post_date,PDO::PARAM_STR);

  $statement->bindParam(":content", $escaped["content"],PDO::PARAM_STR);


  $statement->execute();

  header("Location: recommendDetail.php?id=" . $recommend_id);
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
  <title><?php echo $recommend["title"]; ?></title>
</head>
<body>
  <header class="header">
    <div class="header-logo">

      <h1 class="title"><a href="index.php">myレコ</a></h1>
    </div>
  </header>
<body>

<div class="recommendWrapper">
 <div class="recommendArea">


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
</div>
<hr>
<h3>コメントを書き込む</h3>
<form action="recommendDetail.php?id=<?php echo $recommend_id; ?>" class="commentForm" method="POST">
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
    <?php foreach ($posts as $post) : ?>
      <article>
        <div class ="creatorWrapper">
            <span>投稿者：</span>
            <p class=""><?php echo $post["userName"]; ?></p>
            <time >：<?php echo $post["created_at"]; ?></time>
          </div>
            <span>コメント：</span>
            <p class=""><?php echo $post["content"]; ?></p>
            <a href="./comment.php?post_id=<?php echo $post['id']; ?>&recommend_id=<?php echo $recommend_id; ?>">返信</a>
            <span>コメント数：</span>
            <p><?php echo htmlspecialchars($post["comments_count"], ENT_QUOTES, 'UTF-8'); ?></p>

        <hr>
      </article>
    <?php endforeach ?>
  </section>

</body>
