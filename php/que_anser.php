<?php
session_start();

require_once("../config/config.php");
require_once("../model/Chatt.php");
try {
    // MySQLへの接続
    $chatt = new Chatt($host, $dbname, $user, $pass);
    $chatt->connectDb();

    if(!isset($_SESSION['User'])) {
      header('location: index.php');
      exit;
    } else {
      if($_POST['que']) {

        $_SESSION['que'] = $_POST['que'];
        $queAnserFind = $chatt->queAnserFind($_SESSION['que']);
        $queResFindAll = $chatt->queResFind($_SESSION['que']);
      }

      if($_POST) {
        if(empty($_POST['text'])) {

        } else {
          $chatt->anserAd($_SESSION['User']['id'], $_SESSION['que']);
        }
      }
        $queResFindAll = $chatt->queResFind($_SESSION['que']);
        $queAnserFind = $chatt->queAnserFind($_SESSION['que']);
      // }

      if(isset($_GET['del'])) {
        // print_r($_GET['del']);
        $chatt->queDel($_GET['del']);
        header('location: notice_board.php');
        exit;
      }



      if(isset($_GET['com'])) {
        $chatt->pointAd($_GET['com'],$_SESSION['User']['id']);
        $chatt->queCom($_GET['com']);
        header('location: notice_board.php');
        exit;
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
  <link rel="stylesheet" href="../css/que_anser.css">
  <script type="text/javascript" src="../JS/jquery.js"></script>
  <script type="text/javascript">
  // jQueryを使う方法
  function dojQueryAjax() {

      $.ajax({
          type: "GET",
          url: "que_anser.php",
          cache: false,
          success: function (data) {
              $('#ajaxreload').load(data);
          },
          error: function () {
              alert("Ajax通信エラー");
          }
      });
  }
  window.addEventListener('load', function () {

      setInterval(dojQueryAjax, 5000);

  });
</script>
</head>
<body>
  <header>
    <div class="header_btn" id="header_red">
      <a href="rank.php">1つ前へ</a>
    </div>
    <div class="header_btn" id="header_blue">
      <a href="home.php">ホームへ</a>
    </div>
  </header>
  <div class="wrapper">
    <div class="main">
      <div class="text">
        <p>質問回答</p>
      </div>
      <div class="top">
        <div class="text_sub">
          <p>-質問のタイトル-</p>
        </div>
        <p id="title"><?php print(htmlspecialchars($queAnserFind['title'],ENT_QUOTES)); ?></p>
      </div>
      <div class="text_sub">
        <p>-カリキュラムの名前-</p>
      </div>
      <p id="cari_name"><?php print(htmlspecialchars($queAnserFind['name'],ENT_QUOTES)); ?></p>
      <div class="text_sub">
        <p>-質問の詳細-</p>
      </div>
      <p id="content"><?php print(htmlspecialchars($queAnserFind['contents'],ENT_QUOTES)); ?></p>
      <div class="text_sub">
        <p>-回答チャット-</p>
      </div>
      <div class="chat" id="ajaxreload">
        <?php foreach($queResFindAll as $queResFind) {?>
        <div class="coment_<?php if($_SESSION['User']['id'] == $queResFind['user_id']) { print('right');} else { print('left');} ?>">
          <div class="coment_name"><?php print(htmlspecialchars($queResFind['name'],ENT_QUOTES)); ?></div>
          <div class="coment_inner">
            <div class="coment_content"><?php print(htmlspecialchars($queResFind['chat'],ENT_QUOTES)); ?></div>
            <div class="coment_time"><?php print(htmlspecialchars($queResFind['time'],ENT_QUOTES)); ?></div>
          </div>
        </div>
      <?php } ?>
      </div>
      <?php if($queAnserFind['resolution'] == 0) { ?>
      <form class="chat_in" action="" method="POST">
        <textarea class="chat_text" name="text"></textarea>
        <input type="submit" class="chat_btn">
      </form>
      <p class="error"><?php print(htmlspecialchars($message,ENT_QUOTES)); ?></p>

      <dic class="act_btn">
        <?php if($_SESSION['User']['id'] == $queAnserFind['user_id']) {?>
          <a href="?del=<?php print($_SESSION['que']); ?>" onClick="if(!confirm('この投稿を消しても大丈夫ですか？')) return false;">投稿の削除</a>
          <a href="?com=<?php print($_SESSION['que']); ?>" onClick="if(!confirm('この問題は本当に解決しましたか？')) return false;">解決</a>
        <?php }} ?>
      </div>
    </div>
  </div>
  <footer>
    <p>©︎nagashima co</p>
  </footer>
</body>
</html>
