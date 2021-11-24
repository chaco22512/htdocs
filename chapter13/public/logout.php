<?php

session_start();
require_once '../classes/UserLogic.php';

//POSTでlogout帰ってこなかった場合 
if(!$logout=filter_input(INPUT_POST, 'logout')){
  exit ('Invalid request');
}

// ログインしているかを判定し、セッションが切れていたらログインしてくださいというメッセージを出す
// phpセッションの時間はdefaultで24分
$result = UserLogic::checkLogin();
// ログイン情報がsessionに入っていたら、$result=true, そうでなければfalse
if($result==false){
  exit('Your session is over, so please login again!');
}

// まだセッションが残っていたら、ログアウトする
UserLogic::logout();


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout</title>
</head>
<body>
  <h2>Logout completed</h2>
  <p>Thank you for coming us today!</p>
  <a href="login_form.php">Login Page</a>
</body>
</html>