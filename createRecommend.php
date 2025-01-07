<?php
include("connect.php");

$error_message = array();

if(isset($_POST["submitButton"])) {

  if(empty($_POST["recommendTitle"])) {
    $error_message["title"] ="タイトルを入力してください。";
  } else {
    $escaped["title"] = htmlspecialchars($_POST["recommendTitle"], ENT_QUOTES, "UTF-8");
  }
  if(empty($_POST["userName"])) {
    $error_message["userName"] ="名前を入力してください";
  } else {
    $escaped["userName"] = htmlspecialchars($_POST["userName"], ENT_QUOTES, "UTF-8");
  }
  if(empty($_POST["recommend1"])) {
    $error_message["recommend1"] ="レコメンド１を入力してください";
  } else {
    $escaped["recommend1"] = htmlspecialchars($_POST["recommend1"], ENT_QUOTES, "UTF-8");
  }
  if(empty($_POST["recommend2"])) {
    $error_message["recommend2"] ="レコメンド２を入力してください";
  } else {
    $escaped["recommend2"] = htmlspecialchars($_POST["recommend2"], ENT_QUOTES, "UTF-8");
  }
  if(empty($_POST["recommend3"])) {
    $error_message["recommend3"] ="レコメンド３を入力してください";
  } else {
    $escaped["recommend3"] = htmlspecialchars($_POST["recommend3"], ENT_QUOTES, "UTF-8");
  }
  if(empty($_POST["message"])) {
    $error_message["message"] ="メッセージを入力してください";
  } else {
    $escaped["message"] = htmlspecialchars($_POST["message"], ENT_QUOTES, "UTF-8");
  }

if(empty($error_message)) {

  $post_date = date("Y-m-d H:i:s");

  $sql = "INSERT INTO `recommend` (`title`, `userName`, `post_date`, `recommend1`, `recommend2`, `recommend3`, `message`) VALUES (:title, :userName,:post_date, :recommend1, :recommend2, :recommend3,:message);";

  $statement = $pdo->prepare($sql);

  $statement->bindParam(":title", $escaped["title"],PDO::PARAM_STR);

  $statement->bindParam(":userName", $escaped["userName"],PDO::PARAM_STR);

  $statement->bindParam(":post_date", $post_date,PDO::PARAM_STR);

  $statement->bindParam(":recommend1", $escaped["recommend1"],PDO::PARAM_STR);

  $statement->bindParam(":recommend2", $escaped["recommend2"],PDO::PARAM_STR);


  $statement->bindParam(":recommend3", $escaped["recommend3"],PDO::PARAM_STR);

  $statement->bindParam(":message", $escaped["message"],PDO::PARAM_STR);

  $statement->execute();
}

}

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
      <h2>タイトル</h2>
      <input type="text" name="recommendTitle">
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
      <div class="message">
        <h3>コメント</h3>
        <textarea name="message"></textarea>
      </div>
    </div>
    <div class="createWrapper">
      <div class="create">
        <input type="submit" name="submitButton" value="投稿">
      </div>
    </div>
  </div>

</form>
<?php if(isset($error_message)) : ?>
  <ul class="errorMessage">
    <?php foreach($error_message as $error) : ?>
      <li><?php echo $error ?></li>

    <?php endforeach;?>

  </ul>
<?php endif; ?>
</body>
</html>
