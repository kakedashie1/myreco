<?php
include_once("../database/connect.php");

$sql = "SELECT r.*,
           IFNULL(p.posts_count, 0) AS posts_count,
           IFNULL(c.comments_count, 0) AS comments_count,
           (IFNULL(p.posts_count, 0) + IFNULL(c.comments_count, 0)) AS total_comments_count
    FROM recommend r
    LEFT JOIN (
        SELECT recommend_id, COUNT(*) AS posts_count
        FROM posts
        GROUP BY recommend_id
    ) p ON r.id = p.recommend_id
    LEFT JOIN (
        SELECT p.recommend_id, COUNT(c.id) AS comments_count
        FROM posts p
        LEFT JOIN comment c ON p.id = c.post_id
        GROUP BY p.recommend_id
    ) c ON r.id = c.recommend_id
    ORDER BY total_comments_count DESC, r.post_date DESC
";


$statement = $pdo->prepare($sql);
$statement->execute();
$recommend_array = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="smart.css">
  <title>myレコ</title>
</head>
<body>
  <header class="header">

    <div class="header-logo">
      <h1 class="title"><a href="index.php">myレコ</a></h1>
    </div>
    <div class="header-list">
      <h2 class="register"><a href="createRecommend.php">レコメンドを投稿する</a></h2>
    </div>
  </header>

  <section>
    <?php foreach ($recommend_array as $recommend) : ?>
      <article class="recommendArticle">
      <a href="./recommendDetail.php?id=<?php echo $recommend['id']; ?>" class="linkWrapper">
        <div class ="postWrapper">
          <div class="postArea">
            <div class="titleArea">
              <span>タイトル：</span>
              <p class="recommendTitle"><?php echo $recommend["title"]; ?></p>
              <span>投稿者：</span>
              <p class="userName"><?php echo $recommend["userName"]; ?></p>
              <time >：<?php echo $recommend["post_date"]; ?></time>
            </div>
            <div class="recommend">
              <ol>
                <li><?php echo $recommend["recommend1"]; ?></li>
                <li><?php echo $recommend["recommend2"]; ?></li>
                <li><?php echo $recommend["recommend3"]; ?></li>
              </ol>
            </div>
            
            <span>コメント数：</span>
                            <p><?php echo htmlspecialchars($recommend["total_comments_count"], ENT_QUOTES, 'UTF-8'); ?></p>
          </div>
        </div>
      </a>
        <hr>
      </article>
    <?php endforeach ?>
  </section>
</body>
