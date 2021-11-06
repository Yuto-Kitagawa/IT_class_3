<?php
session_start();
include "./classes/functions.php";
function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.0/swiper-bundle.css" integrity="sha512-lfjMBfE41+3a9XCiuXCjaE4CkvpPOQ5P2qZSZclW9iHsMSvn50dh6ZuB5O8g7uDlCIKFKPqYo8JIka9Rh8HXow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        let d = new Date();
        let date = d.getDate().toLocaleString('ja-JP');

        if (String(date).length == 1) {
            date = "0" + date;
        }

        let month = d.getMonth() + 1;
        if (String(month).length == 1) {
            month = "0" + month;
        }

        let year = d.getFullYear();
        let date_str = String(year) + "-" + String(month) + "-" + String(date);
        console.log(date_str);

        //セッションで一度だけロードする
        if (sessionStorage.getItem("load") != "loaded") {
            sessionStorage.setItem("load", "loaded");
            window.open('index.php?year=' + year + "&month=" + month + "&date=" + date)
            window.location.href = "about:blank";
        }
    </script>
    <?php $_SESSION['URL'] = 'index.php?year=' . strval($_GET['year']) . "&month=" . strval($_GET['month']) . "&date=" . $_GET['date'] ?>

    <?php
    $year = $_GET['year'];
    $month = $_GET['month'];
    $date = $_GET['date'];
    $_SESSION['year'] = $_GET['year'];
    $_SESSION['month'] = $_GET['month'];
    $_SESSION['date'] = $_GET['date'];
    $week = [
        '日', //0
        '月', //1
        '火', //2
        '水', //3
        '木', //4
        '金', //5
        '土', //6
    ];
    $func = new Functions;

    $race_array = $func->compareDate($year, $month, $date); //return race in this week
    ?>
</head>

<body>
    <header>
        <div class="header__imgBox">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="./img/AdobeStock_96604330.jpeg" alt=""></div>
                    <div class="swiper-slide"><img src="./img/AdobeStock_44616117.jpeg" alt=""></div>
                    <div class="swiper-slide"><img src="./img/AdobeStock_193895109.jpeg" alt=""></div>
                </div>
            </div>
            <h2><img src="./img/index_main_img_text.svg" alt=""></h2>
        </div>
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
        <div class="toggle">
            <img src="img/help-btn.svg" alt="" onclick="btnCtr()">
        </div>
    </header>

    <!-- モーダルウィンドウ -->
    <div class="modal">
        <div class="modal__content">
            <div class="modal__content__flex">
                <div class="swiper-container header__swiper__modal">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="img/AdobeStock_96604330.jpeg" alt=""></div>
                        <div class="swiper-slide"><img src="img/AdobeStock_44616117.jpeg" alt=""></div>
                        <div class="swiper-slide"><img src="img/AdobeStock_193895109.jpeg" alt=""></div>
                    </div>
                </div>
                <div class="modal__content__flex__btn" onclick="btnCtr()" class="toggle__btn">
                    <img src="img/modal-delete.svg" alt="">
                </div>
                <div class="modal__content__flex__text">
                    <h2>レース予想</h2>
                    <p>AIがレースを予想します。<br>
                        「予想を見る」ボタンを押して、レースの予想を見てみましょう。</p>
                </div>
            </div>
        </div>
    </div>
    <!-- モーダルウィンドウ -->

    <!-- レース情報 -->
    <div class="race">
        <h2>今週のレース</h2>
        <div class="race__box">
            <div class="race__box__main">
                <div class="race__box__main__title">
                    <h3><?= $race_array[0]['name'] ?><span><?= $race_array[0]['grade'] ?></span></h3>
                    <p><?= $race_array[0]['location'] ?> <?= $race_array[0]['style'] ?> <?= $race_array[0]['distance'] ?>m</p>
                    <p><?= substr($race_array[0]['date'], -4, -2) ?>月<?= substr($race_array[0]['date'], -2) ?>日 (
                        <span>
                            <?php $timestamp = mktime(0, 0, 0, substr($race_array[0]['date'], -3, -2), substr($race_array[0]['date'], -2), substr($race_array[0]['date'], -8, -5));
                            $date_1 = date('w', $timestamp);
                            echo $week[$date_1];
                            ?></span>)
                    </p>
                </div>

                <!-- ここから今週のレースの馬の一覧の表の処理 -->
                <div class="race__box__main__table">
                    <table rules="all">
                        <tr>
                            <th>枠番</th>
                            <th>馬番</th>
                            <th>馬名</th>
                            <th>オッズ</th>
                        </tr>
                        <?php
                        $list_array = $func->getRaceInformations($race_array[0]['id']);
                        for ($i = 0; $i < count($list_array); $i++) {
                        ?>
                            <tr>
                                <td><?= $list_array[$i]['FRAME_NUMBER'] ?></td>
                                <td><?= $list_array[$i]['HORSE_NUMBER'] ?></td>
                                <td><?= $list_array[$i]['HORSE_NAME'] ?></td>
                                <td>?</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div class="race__box__main__expected">
                    <p><a href="./raceExpected.php?id=<?= $race_array[0]['id'] ?>">予想を見る</a></p>
                </div>
            </div>
            <div class="race__box__sub">
                <?php
                $flag = count($race_array);
                $i = 1;
                while ($i < $flag) {
                ?>
                    <div class="race__box__sub__items">
                        <a href="./raceExpected.php?id=<?= $race_array[$i]['id'] ?>">
                            <h3><?= $race_array[$i]['name'] ?><span class="GroupRace"><?= $race_array[$i]['grade'] ?></span></h3>
                            <p><?= $race_array[$i]['location'] ?> <?= $race_array[$i]['style'] ?> <?= $race_array[1]['distance'] ?>m</p>
                            <p><?= substr($race_array[$i]['date'], -4, -2) ?>月<?= substr($race_array[$i]['date'], -2) ?>日(
                                <?php $timestamp = mktime(0, 0, 0, substr($race_array[$i]['date'], -3, -2), substr($race_array[$i]['date'], -2), substr($race_array[$i]['date'], -8, -5));
                                $date_1 = date('w', $timestamp);
                                echo $week[$date_1];
                                ?>)
                            </p>
                        </a>
                    </div>
                <?php
                    $i += 1;
                }
                ?>
            </div>
        </div>
    </div>
    <!-- レース情報 -->

    <div class="balance">
        <h1>残高確認</h1>
        <div class="balance__box">
            <?php
            if (empty($_SESSION['username'])) {
            ?>
                <div style="width: 100%;height:100%;text-align:center;font-size:3em;color:black;justify-content:center;display:flex;align-items:center;"><a style="color:blue;" href=" ./login.php">ログイン</a>してください</div>
            <?php
            } else {
                #収支の履歴を取得
                $result_2 = $func->getPayment($_SESSION['id']);
                $balance_index = $func->getBalance($_SESSION['id']);
                $_SESSION['balance'] = $balance_index['BALANCE'];
            ?>
                <div class="balance__box__content">
                    <h3>現在の残高</h3>
                    <h2><?= $_SESSION['balance'] ?><span>G</span></h2>
                    <p>直近の収支</p>
                    <div class="balance__box__content__table">
                        <table rules="all" bordercolor="#E0E0E0">
                            <tr>
                                <th>項目</th>
                                <th>お預り金額</th>
                                <th>お支払金額</th>
                                <th>現在高</th>
                            </tr>
                            <?php
                            for ($i = 0; $i < count($result_2); $i++) {
                            ?>
                                <tr>
                                    <td><?php
                                        if (empty(!$result_2[$i]["SERVICE"])) {
                                            echo $result_2[$i]["SERVICE"];
                                        }
                                        ?></td>
                                    <td><?php
                                        if (empty(!$result_2[$i]["BET"])) {
                                            echo $result_2[$i]["BET"];
                                        }
                                        ?></td>
                                    <td><?php
                                        if (empty(!$result_2[$i]["REFUND"])) {
                                            echo $result_2[$i]["REFUND"];
                                        }
                                        ?></td>
                                    <td><?php
                                        if (empty(!$result_2[$i]["BALANCE"])) {
                                            echo $result_2[$i]["BALANCE"];
                                        }
                                        ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <footer>
        <ul>
            <li><a href="#">レース一覧</a></li>
            <li><a href="#">ランキング</a></li>
            <li><a href="#">マイページ</a></li>
            <li><a href="./actions/logout.php">ログアウト</a></li>
            <li><a href="#">残高確認</a></li>
        </ul>
        <div class="footer__logo">
            <a href="#"><img src="img/logo.svg" alt=""></a>
        </div>
        <p><small>copyright ©</small>2021 ヤブサメ All Rights Reversed.</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.0/swiper-bundle.min.js" integrity="sha512-qqdD5ZLIGB5PCqCk1OD8nFBr/ngB5w+Uw35RE/Ivt5DK35xl1PFVkuOgAbqFpvtoxX6MpRGLmIqixzdhFOJhnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/index.js"></script>
</body>

</html>