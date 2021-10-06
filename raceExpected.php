<?php
session_start();
include "./classes/functions.php";
function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}
$week = [
    '日', //0
    '月', //1
    '火', //2
    '水', //3
    '木', //4
    '金', //5
    '土', //6
];
$race_id = $_GET['id'];
$func = new Functions;
#GET informations of the race_list
$race_detail_array = $func->extractRace($race_id);
$race_detail = $race_detail_array->fetch_assoc();

#GET details of the race
$race_order = $func->getRaceInformations($race_id);
// $func -> Confirmation(count($race_order));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>raceExpected</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/raceListPredict.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.0/swiper-bundle.css" integrity="sha512-lfjMBfE41+3a9XCiuXCjaE4CkvpPOQ5P2qZSZclW9iHsMSvn50dh6ZuB5O8g7uDlCIKFKPqYo8JIka9Rh8HXow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <div class="PredictCotent">
        <h3><?= $race_detail['name'] ?><span><?= $race_detail['grade'] ?></span></h3>
        <p><?= $race_detail['location'] ?>競馬場 <?= $race_detail['style'] ?> <?= $race_detail['distance'] ?>m </p>
        <p><?= substr($race_detail['date'], -3, -2) ?>月<?= substr($race_detail['date'], -2) ?>日 (
            <?php $timestamp = mktime(0, 0, 0, substr($race_detail['date'], -3, -2), substr($race_detail['date'], -2), substr($race_detail['date'], -8, -5));
            $date_1 = date('w', $timestamp);
            $date_1 = trim($date_1);
            echo ($week[$date_1]);
            ?>
            )</p>
        <div class="flex">
            <div class="PredictCotent__table">
                <table rules="all">
                    <tr>
                        <th>予想</th>
                        <th>年齢</th>
                        <th>枠番</th>
                        <th>馬番</th>
                        <th>馬名</th>
                    </tr>
                    <!-- 表の予想と人気は１番２番３番にはそれぞれ色がつくようにするので
                    classで1="first"2="second"3="third"とつけれるようにお願いします -->
                    <!-- 予想、人気、枠、馬番、馬名の順で並んでいる -->
                    <?php if (count($race_order) == 0) {
                    ?>
                        <tr>
                            <td colspan=5>また発表されていません。<br>もうしばらくお待ちください。</td>
                        </tr>

                    <?php } else { ?>
                        <tr>
                            <td class="first">1</td>
                            <td><?= $race_order[0]['HORSE_AGE'] ?></td>
                            <td><?= substr($race_order[0]['FRAME_NUMBER'], 0, 1) ?></td>
                            <td><?= $race_order[0]['HORSE_NUMBER'] ?></td>
                            <td><?= $race_order[0]['HORSE_NAME'] ?></td>
                        </tr>
                        <tr>
                            <td class="second">2</td>
                            <td><?= $race_order[1]['HORSE_AGE'] ?></td>
                            <td><?= substr($race_order[1]['FRAME_NUMBER'], 0, 1) ?></td>
                            <td><?= $race_order[1]['HORSE_NUMBER'] ?></td>
                            <td><?= $race_order[1]['HORSE_NAME'] ?></td>
                        </tr>
                        <tr>
                            <td class="third">3</td>
                            <td><?= $race_order[2]['HORSE_AGE'] ?></td>
                            <td><?= substr($race_order[2]['FRAME_NUMBER'], 0, 1) ?></td>
                            <td><?= $race_order[2]['HORSE_NUMBER'] ?></td>
                            <td><?= $race_order[2]['HORSE_NAME'] ?></td>
                        </tr>

                        <?php
                        $length = count($race_order);
                        for ($i = 3; $i < $length; $i++) {
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $race_order[$i]['HORSE_AGE'] ?></td>
                                <td><?= substr($race_order[$i]['FRAME_NUMBER'], 0, 1) ?></td>
                                <td><?= $race_order[$i]['HORSE_NUMBER'] ?></td>
                                <td><?= $race_order[$i]['HORSE_NAME'] ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
            <div class="PredictCotent__time">
                <h2><?= $race_detail['name'] ?>の過去最速タイム</h2>
                <?php
                $race_one = $func->getFastHorse($race_detail['name']);
                ?>
                <time><?= $race_one[0]['RACE_TIME'] ?></time>
                <div class="PredictCotent__time__flex">
                    <h3>馬名</h3>
                    <p class="bgColor"><?= $race_one[0]['HORSE_NAME'] ?></p>
                </div>
                <div class="PredictCotent__time__flex">
                    <h3>月日</h3>
                    <p>
                        <?php $date_array = $func->getRaceDate($race_one[0]['RACE_NUMBER']);
                        $date = $date_array->fetch_assoc();
                        ?>
                        <?= substr($date['date'], 0, 4) ?>年
                        <?= substr($date['date'], 4, 2) ?>月
                        <?= substr($date['date'], 6, 2) ?>日
                    </p>
                </div>
                <div class="PredictCotent__time__flex">
                    <h3>馬場</h3>
                    <p class="bgColor"><?= $date['style'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- ここからチケット関係 -->
    <div class="ticket">
        <h2>馬券別予想</h2>
        <ul>
            <li class="is-active tab tab-A">単勝</li>
            <li class="tab tab-B">複勝</li>
            <li class="tab tab-D">枠連</li>
            <li class="tab tab-H">3連複</li>
            <li class="tab tab-I">3連単</li>
        </ul>
        <div class="ticket__box tab-A is-show">
            <div class="ticket__box__content">
                <div class="ticket__box__content__flex">
                    <div class="ticket__box__content__flex__items">
                        <h3><?= $race_detail["name"] ?> 単勝</h3>
                        <div class="ticket__box__content__flex__items__number">
                            <!-- 発表される前は表示させない -->
                            <?php
                            if (count($race_order) == 0) {
                            ?>
                                <p class="name">まだ発表されていません</p>
                            <?php } else {
                                $tansyou = $func->getTansyou($race_id);
                                $tansyou_index = $tansyou->fetch_assoc();
                                $tansyou_horse = $tansyou_index["HORSE_NUMBER"];
                            ?>
                                <!-- ドロップダウンを一つ選択できるようにする -->
                                <p class="number"><?= $tansyou_horse ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ticket__box tab-B">
            <div class="ticket__box__content">
                <div class="ticket__box__content__flex">
                    <div class="ticket__box__content__flex__items">
                        <h3><?= $race_detail["name"] ?> 複勝</h3>
                        <div class="ticket__box__content__flex__items__number">
                            <?php
                            if (count($race_order) == 0) {
                            ?>
                                <p class="name">まだ発表されていません</p>

                            <?php
                            } else {
                            ?>
                                <p class="number"><?= $tansyou_horse ?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ticket__box tab-D">
            <div class="ticket__box__content">
                <div class="ticket__box__content__flex">
                    <div class="ticket__box__content__flex__items">
                        <h3><?= $race_detail["name"] ?> 枠連</h3>
                        <div class="ticket__box__content__flex__items__number">
                            <?php
                            if (count($race_order) == 0) {
                            ?>
                                <p class="name">まだ発表されていません</p>

                            <?php
                            } else {
                                $waku_array = $func->getWaku($race_id);
                            ?>
                                <p class="number"><?= $waku_array[0]["FRAME_NUMBER"] ?></p>
                                <p>→</p>
                                <p class="number"><?= $waku_array[1]["FRAME_NUMBER"] ?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ticket__box tab-H">
            <div class="ticket__box__content">
                <div class="ticket__box__content__flex">
                    <div class="ticket__box__content__flex__items">
                        <h3><?= $race_detail["name"] ?> 3連複</h3>
                        <div class="ticket__box__content__flex__items__number">
                            <?php
                            if (count($race_order) == 0) {
                            ?>
                                <p class="name">まだ発表されていません</p>

                            <?php
                            } else {
                                $sanren = $func->getSanren($race_id);
                            ?>
                                <p class="number"><?= $sanren[0]["HORSE_NUMBER"] ?></p>
                                <p>→</p>
                                <p class="number"><?= $sanren[1]["HORSE_NUMBER"] ?></p>
                                <p>→</p>
                                <p class="number"><?= $sanren[2]["HORSE_NUMBER"] ?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ticket__box tab-I">
            <div class="ticket__box__content">
                <div class="ticket__box__content__flex">
                    <div class="ticket__box__content__flex__items">
                        <h3><?= $race_detail["name"] ?> 3連単</h3>
                        <div class="ticket__box__content__flex__items__number">
                            <?php
                            if (count($race_order) == 0) {
                            ?>
                                <p class="name">まだ発表されていません</p>

                            <?php
                            } else {
                                $santan = $func->getSantan($race_id);
                            ?>
                                <p class="number"><?= $santan[0]["HORSE_NUMBER"] ?></p>
                                <p>→</p>
                                <p class="number"><?= $santan[1]["HORSE_NUMBER"] ?></p>
                                <p>→</p>
                                <p class="number"><?= $santan[2]["HORSE_NUMBER"] ?></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
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
            <a href="#"><img src="./img/logo.svg" alt=""></a>
        </div>
        <p><small>copyright ©</small>2021 ヤブサメ All Rights Reversed.</p>
    </footer>
    <script src="js/raceExpected.js"></script>
</body>