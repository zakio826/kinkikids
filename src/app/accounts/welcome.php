<?php
//ログイン後の画面PHP

session_start();
// セッション変数 $_SESSION["loggedin"]を確認。ログイン済だったらウェルカムページへリダイレクト
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ 
            font: 14px sans-serif;
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1 class="my-5">Hi,<b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
    <a href="../index.php">ホーム</a>
    <a href="../point/help_add.php">お<ruby>手伝<rt>てつだ</rt></ruby>い</a>
    <a href="../goal/goal.php"><ruby>目標<rt>もくひょう</rt></ruby></a>
</body>
</html>
