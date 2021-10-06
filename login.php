<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/raceListPredict.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.0/swiper-bundle.css" integrity="sha512-lfjMBfE41+3a9XCiuXCjaE4CkvpPOQ5P2qZSZclW9iHsMSvn50dh6ZuB5O8g7uDlCIKFKPqYo8JIka9Rh8HXow==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>LOGIN</title>
</head>

<body>
    <header>
        <nav>
            <div class="nav">
                <div class="nav__bg"></div>
                <div class="nav__flex">
                    <div class="nav__flex__logo">
                        <h1><a href="#"><img src="./img/logo.svg" alt=""></a></h1>
                    </div>
                    <div class="nav__flex__items">
                        <ul>
                            <li><a href="./<?= $_SESSION['URL'] ?>">ホーム</a></li>
                            <li><a href="./raceList.php">今週のレース</a></li>
                            <li><a href="#">ランキング(未完成)</a></li>
                            <li><a href="#">マイページ(未完成)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="contents-wrapper">
        <div class="contents">
            <h1 class="h1_log">ログイン</h1>
            <form action="./actions/login.php" method="post" class="form_log">
                <div style="text-align: center;">
                    <input type="name" name="mail" class="textbox name" placeholder="メールアドレス"><br>
                </div>
                <div>
                    <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br>
                </div>
                <div>
                    <button type="submit" class="log_button">ログインする</button>
                </div>
            </form>
            <hr class="innerhr">

            <div class="fotter">
                <a href="./contact.php">新規登録はこちら</a>
            </div>
        </div>
    </div>


</body>

</html>