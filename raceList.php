<?php
session_start();
include "./classes/functions.php";

$week = [
    '日', //0
    '月', //1
    '火', //2
    '水', //3
    '木', //4
    '金', //5
    '土', //6
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>raceList</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/raceList.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.0/swiper-bundle.css" integrity="sha512-lfjMBfE41+3a9XCiuXCjaE4CkvpPOQ5P2qZSZclW9iHsMSvn50dh6ZuB5O8g7uDlCIKFKPqYo8JIka9Rh8HXow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <li><a href="./<?= $_SESSION['URL'] ?>">ホーム</a></li>
                            <li><a href="#">今週のレース</a></li>
                            <li><a href="#">ランキング(未完成)</a></li>
                            <li>
                                <?php
                                if (empty($_SESSION['username'])) {
                                ?>
                                    <a href="./login.php">ログイン
                                    <?php
                                } else {
                                    ?>
                                        <a href="#"><?= $_SESSION['username'] ?></a>
                                    <?php
                                }
                                    ?>
                                    </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="list">
        <h2>今週のレース</h2>

        <?php
        $func = new Functions();
        $race_array = $func->compareDate($_SESSION['year'], $_SESSION['month'], $_SESSION['date']);

        //今週のレース文表示させる
        for ($i = 0; $i < count($race_array); $i++) {
            $race_detail_array = $func->extractRace($race_array[$i]['id']);
            $race_detail = $race_detail_array->fetch_assoc();
        ?>

            <p><?= substr($race_detail['date'], -3, -2) ?>月<?= substr($race_detail['date'], -2) ?>日 (
                <?php $timestamp = mktime(0, 0, 0, substr($race_detail['date'], -3, -2), substr($race_detail['date'], -2), substr($race_detail['date'], -8, -5));
                $date_1 = date('w', $timestamp);
                $date_1 = trim($date_1);
                echo ($week[$date_1]);
                ?>
                )</p>
            </p>
            <div class="list__content">
                <div class="list__content__race">
                    <h3><?= $race_array[$i]['name'] ?><span class="GroupRace"><?= $race_array[$i]['grade'] ?></span></h3>
                    <p><?= $race_array[$i]['location'] ?>競馬場 <?= $race_array[$i]['distance'] ?>m <?= $race_array[$i]['style'] ?></p>
                </div>
                <div class="list__content__expected">
                    <div class="list__content__expected__btn">
                        <a href="./raceExpected.php?id=<?= $race_array[$i]['id'] ?>">このレースのAI着順予想を見る</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>