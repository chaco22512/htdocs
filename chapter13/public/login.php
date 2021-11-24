<?php
// セッション開始
session_start();

require_once '../classes/UserLogic.php';


$err =[];

// Validation
$email = filter_input(INPUT_POST, 'email');
if(!$email){
  $err['email'] = 'Please input your email adress';
}
$password = filter_input(INPUT_POST, 'password');
// 今回は有っているかどうかのバリデーション
if(!$password){
  $err['password'] = 'Please input your password';
}


// エラーがあった場合、画面を戻す
if (count($err)>0){
  // セッション配列にエラーメッセージを入れる
  $_SESSION = $err;
  header('Location: login_form.php');
  return;
}

// ログイン成功時の処理
$result = UserLogic::login($email, $password);

// ログイン失敗時
if(!$result){
  header('Location: login_form.php');
  return;
}
// echo "you succeeded to login in our service";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Completed</title>
</head>
<body>
  <h2>Login finished</h2>
  <p>You finished to login in our Service!!</p>
  <a href="mypage.php">To Mypege</a>
</body>
</html>