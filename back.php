<?php
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
    <link rel="stylesheet" href="../../css/index.css">
    <link rel="stylesheet" href="../../css//header.css">
    <link rel="stylesheet" href="../../css/ress.css">
    <link rel="stylesheet" href="../../css/common.css">
    <link rel="stylesheet" href="../../css//vars.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.0/swiper-bundle.css" integrity="sha512-lfjMBfE41+3a9XCiuXCjaE4CkvpPOQ5P2qZSZclW9iHsMSvn50dh6ZuB5O8g7uDlCIKFKPqYo8JIka9Rh8HXow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        let url = new URL(window.location);
        let d = new Date();
        let date = d.getDate();
        if (String(date).length == 1) {
            date = "0" + date;
        }
        let month = d.getMonth() + 1;
        if (String(month).length == 1) {
            month = "0" + month;
        }
        let year = d.getFullYear();
        let date_str = year + "-" + month + "-" + date;

        //なぜかURLに反映されないが、console画面では反応する
        //一応JSの方でもクエリ文字を反映させておきます。
        url.searchParams.append('date', String(date_str));
        console.log("get: " + url.searchParams.get('date'));
        //解決策↓
        history.replaceState('', '', 'index.php?year=' + year + "&month=" + month + "&date=" + date);
    </script>

    <?php
    $year = $_GET['year'];
    $month = $_GET['month'];
    $date = $_GET['date'];
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
                    <div class="swiper-slide"><img src="../../img/AdobeStock_96604330.jpeg" alt=""></div>
                    <div class="swiper-slide"><img src="../../img/AdobeStock_44616117.jpeg" alt=""></div>
                    <div class="swiper-slide"><img src="../../img/AdobeStock_193895109.jpeg" alt=""></div>
                </div>
            </div>
            <h2><img src="../../img/index_main_img_text.svg" alt=""></h2>
        </div>
        <nav>
            <div class="nav">
                <div class="nav__bg"></div>
                <div class="nav__flex">
                    <div class="nav__flex__logo">
                        <h1><a href="#"><img src="../../img/logo.svg" alt=""></a></h1>
                    </div>
                    <div class="nav__flex__items">
                        <ul>
                            <li><a href="#">ホーム</a></li>
                            <li><a href="#">レース予想</a></li>
                            <li><a href="#">ランキング</a></li>
                            <li><a href="#">マイページ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- レース情報 -->
    <div class="race">
        <h2>今週のレース</h2>
        <div class="race__box">
            <div class="race__box__main">
                <div class="race__box__main__title">
                    <h3><?= $race_array[0]['name'] ?><span><?= $race_array[0]['grade'] ?></span></h3>
                    <p><?= $race_array[0]['location'] ?> <?= $race_array[0]['style'] ?> <?= $race_array[0]['distance'] ?>m</p>
                    <p><?= substr($race_array[0]['date'], -3, -2) ?>月<?= substr($race_array[0]['date'], -2) ?>日 (
                        <?php $timestamp = mktime(0, 0, 0, substr($race_array[0]['date'], -3, -2), substr($race_array[0]['date'], -2), substr($race_array[0]['date'], -8, -5));
                        $date_1 = date('w', $timestamp);
                        echo $week[$date_1];
                        ?>)</p>
                </div>
                <div class="race__box__main__table">
                    <table rules="all">
                        <tr>
                            <th>枠番</th>
                            <th>馬番</th>
                            <th>馬名</th>
                            <th>オッズ</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>1</td>
                            <td>エフフォーリア</td>
                            <td>1.7</td>
                        </tr>
                    </table>
                </div>
                <div class="race__box__main__expected">
                    <p><a href="#">予想を見る</a></p>
                </div>
            </div>
            <div class="race__box__sub">
                <?php
                $flag = count($race_array);
                $i = 1;
                while ($i < $flag) {
                ?>
                    <div class="race__box__sub__items">
                        <a href="#">
                            <h3><?= $race_array[$i]['name'] ?><span class="GroupRace"><?= $race_array[$i]['grade'] ?></span></h3>
                            <p><?= $race_array[$i]['location'] ?> <?= $race_array[$i]['style'] ?> <?= $race_array[1]['distance'] ?>m</p>
                            <p><?= substr($race_array[$i]['date'], -3, -2) ?>月<?= substr($race_array[$i]['date'], -2) ?>日(
                                <?php $timestamp = mktime(0, 0, 0, substr($race_array[$i]['date'], -3, -2), substr($race_array[$i]['date'], -2), substr($race_array[$i]['date'], -8, -5));
                                $date_1 = date('w', $timestamp);
                                echo $week[$date_1];
                                ?>)</p>
                            <!-- 曜日取れてません -->
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
        <h2>残高確認</h2>
        <div class="balance__box">
            <div class="balance__box__content">
                <h3>現在の残高</h3>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.0/swiper-bundle.min.js" integrity="sha512-qqdD5ZLIGB5PCqCk1OD8nFBr/ngB5w+Uw35RE/Ivt5DK35xl1PFVkuOgAbqFpvtoxX6MpRGLmIqixzdhFOJhnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/index.js"></script>
</body>

</html>