<?php

session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

// ログインしているかを判定し、していなかったら新規登録画面へ
$result = UserLogic::checkLogin();
// ログイン情報がsessionに入っていたら、$result=true, そうでなければfalse
if($result==false){
  $_SESSION['login_err'] = 'Please register your user and login it.';
  header('Location: signup_form.php');
  return;
}

// 成功した場合は、sessionのlogin userなどを取ってくる
$login_user = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mypage</title>
</head>
<body>
  <h2>Mypage</h2>
  <p>Login User:　<?php echo h($login_user['name']); ?> </p>
  <p>MailAdress:　<?php echo h($login_user['email']); ?> </p>
  <!-- ログアウト機能実装 -->
  <form action="logout.php" method="post">
    <input type="submit" name="logout" value="Logout">
  </form>
</body>
</html>