<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");
try {
    // MySQLへの接続
  $user = new User($host, $dbname, $user, $pass);
  $user->connectDb();

  if(!isset($_SESSION['User']) || $_SESSION['User']['role'] != 1) {
    header('location: index.php');
    exit;
  } else {
    $manage = $user->manage();

    if($_POST['name']) {
      $manage = $user->search($_POST['name']);
    }

    if($_POST['status']) {
      $statusFind = $user->statusFind($_POST['status']);
      $user->status($statusFind['status'], $statusFind['id']);
      $manage = $user->manage();
    }
  }

  $db = null;
  $sth = null;
} catch (PDOException $e) {
    print "エラー!: " . $e->getMessage() . "<br/gt;";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>PHP自作</title>
  <link rel="stylesheet" href="../css/bace.css">
  <link rel="stylesheet" href="../css/manage.css">
</head>
<body>
  <header>
    <div class="header_btn" id="header_red">
      <a href="add.php">新規登録</a>
    </div>
    <div class="header_btn" id="header_blue">
      <a href="rank.php">質問へ</a>
    </div>
    <div class="header_btn" id="header_yellow">
      <a href="home.php">1つもどる</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="main">
      <div class="text">
        <p>管理ページ</p>
      </div>
      <div class="manage_top">
        <form class="search" action="" method="POST">
          <input type="text" name="name" size="25" placeholder="　受講生の検索" id="search_top">
          <input type="submit" value="検索" id="search_bottom">
        </form>
      </div>
      <div class="students">
        <?php foreach($manage as $mana) { ?>
        <div class="student">
          <div class="student_text">
            <p><?php print(htmlspecialchars($mana['name'])) ?></p>
            <p id="state">（<?php if($mana['status'] == 0) {
                    print('カリキュラム取組中');
                  } else {
                    print('カリキュラム終了');
                  } ?>）
            </p>
          </div>
          <div class="student_btn">
            <form action="" method="POST">
              <input type="hidden" value=<?php print($mana['id']); ?> name="status">
              <input type="submit" value="ステータス変更" id="status_btn">
            </form>
            <form action="plan.php" method="POST">
              <div class="plan_btn">
                <input type="hidden" value=<?php print(htmlspecialchars($mana['id'])); ?> name="id">
                <input type="submit" value="計画の変更" id="plan_change">
              </div>
            </form>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  <footer>
    <p>©︎nagashima co</p>
  </footer>
</body>
</html>
