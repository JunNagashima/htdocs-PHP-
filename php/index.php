<?php
session_start();

require_once("../config/config.php");
require_once("../model/User.php");

try {
    // MySQLへの接続
    $user = new User($host, $dbname, $user, $pass);
    $user->connectDb();

    if($_POST) {
      // print_r($_POST);

      $result = $user->login($_POST);


        if(empty($_POST['name'] && $_POST['address'] && $_POST['pass'])) {
          $message = '未入力な項目があります。';
        } else {
          if (filter_var($_POST['address'], FILTER_VALIDATE_EMAIL)) {
            if(!empty($result)) {
              $_SESSION['User'] = $result;
              if($_SESSION['User']['status'] == 0) {
                header('Location: home.php');
                exit;
              } else {
                $_SESSION = array();
                $message = 'ロックされているアカウントです。';
              }
            } else {
              $message = '該当するアカウントがありません。';
            }
          }else {
            $message = '不正な形式のメールアドレスです。';
          }
        }




    }


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
  <link rel="stylesheet" href="../css/index.css">
</head>
<body>
  <div class="top">
    <form action="" method="POST" id="login_form">
      <table>
        <tr>
          <td class="login_td_left">名前</td>
          <td class="login_td_right"><input type="text" name="name" class="top_text" id="top_red"></td>
        </tr>
        <tr>
          <td class="login_td_left">メールアドレス</td>
          <td class="login_td_right"><input type="text" name="address" class="top_text" id="top_blue"></td>
        </tr>
        <tr>
          <td class="login_td_left">パスワード</td>
          <td class="login_td_right"><input type="password" name="pass" class="top_pass" id="top_yellow"></td>
        </tr>
      </table>
      <p class="error"><?php print(htmlspecialchars($message,ENT_QUOTES)); ?></p>
      <input type="submit" value="ログイン" class="top_btn">
    </form>
  </div>
</body>
</html>
