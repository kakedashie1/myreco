<?php
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
    <h1 class="title">myレコ</h1>
  </header>
<form class="formWrapper" method="POST">
  <div class="titleWrapper">
    <div class="recommendTitle">
      <h2>title</h2>
    </div>
    <div class="creator">
      <h3>投稿者：</h3>
      <input type="text" name="userName">
    </div>
    <hr>
  </div>
  <div class="recommendWrapper">
    <div class="recommend">
      <h3>レコメンド</h3>
      <ol>
        <li><input type="text" name="recommend1"></li>
        <li><input type="text" name="recommend2"></li>
        <li><input type="text" name="recommend3"></li>
      </ol>
    </div>
    <div class="massageWrapper">
      <div class="massage">
        <h3>コメント</h3>
        <textarea name="comment"></textarea>
      </div>
    </div>
    <div class="createWrapper">
      <div class="create">
        <input type="submit" name="submitButton" value="投稿">
      </div>
    </div>
  </div>

</form>
</body>
</html>
