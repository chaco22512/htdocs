<?php

session_start();

require_once '../classes/UserLogic.php';

$err =[];

// signup_formで作られ、送られたtoken
$token = filter_input(INPUT_POST, 'csrf_token');
// tokenがない、もしくは一致しない場合、処理中止
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
  exit('Invalid request');
}
// 2重送信されると、1回目で下が動き、csrf_tokenが無くなるので、2回目で上に引っかかる
unset($_SESSION['csrf_token']);

// Validation
$username = filter_input(INPUT_POST, 'username');
if(!$username){
  $err[] = 'Please input your username';
}
$email = filter_input(INPUT_POST, 'email');
if(!$email){
  $err[] = 'Please input your email adress';
}
$password = filter_input(INPUT_POST, 'password');
$password_conf = filter_input(INPUT_POST, 'password_conf');
// パスワードのバリデーションには、正規表現を用いる
if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
  $err[] = 'Please set your password alphabet between 8-100 words';
}
if($password!==$password_conf){
  $err[]='Your password is not matched at all.';
}


// ユーザー登録する処理⇒データーベースへ！
if (count($err)===0){
  // クラスとして分離させたい⇒別のファイルへ　UserLogicクラス、createUser() functionを別ファイルで実装
  // static関数として定義⇒インスタンス化不要
  // 引数はポストで受け取った値
  // returnはboolean
  $hasCreated  = UserLogic::createUser($_POST);

  if(!$hasCreated){
    $err[] ='You failed the regislation';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regislation result</title>
</head>
<body>
  <?php if (count($err)>0) : ?>
  <?php foreach($err as $e) : ?>
    <p><?php echo $e ?></p>
  <?php endforeach ?>
  <?php else : ?>
  <p>You finished to register our Service!!</p>
  <?php endif ?>
  <a href="signup_form.php">Return</a>
</body>
</html>