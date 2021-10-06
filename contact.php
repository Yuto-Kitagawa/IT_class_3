<?php
session_start();
?>

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>contact</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/contact.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <header>
    <nav>
      <div class="nav">
        <div class="nav__bg"></div>
        <div class="nav__flex">
          <div class="nav__flex__logo">
            <h1><a href="#"><img src="img/logo.svg" alt=""></a></h1>
          </div>
          <div class="nav__flex__items">
            <ul>
              <li><a href="<?= $_SESSION['URL'] ?>">ホーム</a></li>
              <li><a href="./raceList.php">レース予想</a></li>
              <li><a href="#">ランキング</a></li>
              <li><a href="<?= $_SESSION['URL'] ?>">マイページ</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <div class="form_container">
    <h1>新規登録</h1>
    <form action="./actions/createUser.php" method="POST">
      <div class="input_comtainer">
        <div class="input_name">
          <div class="input_box">
            <label for="name">ユーザー名</label>
            <div class="change_span">
              必須
            </div>
          </div>
          <input type="name" placeholder="ヤブサメタロウ" name="username">
        </div>
        <div class="input_email">
          <div class="input_box">
            <label for="email">メールアドレス</label>
            <div class="change_span">
              必須
            </div>
          </div>
          <input type="email" placeholder="yabusame.keiba@example.com" name="email">
        </div>
        <div class="input_pass">
          <div class="input_box">
            <label for="pass">パスワード</label>
            <div class="change_span">
              必須
            </div>
          </div>
          <input type="password" placeholder="パスワード" name="password">
        </div>
        <div class="input_pass_tow">
          <div class="input_box">
            <label for="pass2">確認のため、もう一度パスワードを入力してください</label>
            <div class="change_span">
              必須
            </div>
          </div>
          <input type="password" placeholder="パスワード" name="password2">
        </div>
        <button type="submit">登録する</button>
      </div>
    </form>

  </div>
</body>