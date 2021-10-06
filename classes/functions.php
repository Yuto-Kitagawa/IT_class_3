<?php

require_once "database.php";

class Functions extends Database
{

    public function compareDate($year, $month, $date)
    {
        $today = intval($year . $month . $date);
        $date = (int)$date + 7;
        if ($date >= 29) {
            list($month, $date) = $this->adjastDate($year, $month, $date);
        }
        $date_str = $this->adjastZero($year, $month, $date);
        $date_int = intval($date_str); //string to int

        $sql = "SELECT id, `date`,`name`,grade,`location`,style,distance FROM race_list WHERE `date` <= $date_int && `date` >= $today";
        $result = $this->conn->query($sql);

        $race_name_list = new ArrayObject();

        while ($race_name = $result->fetch_assoc()) {
            $race_name_list->append($race_name);
        }
        return $race_name_list;
    }

    public function adjastZero($year, $month, $date)
    {
        if (strlen($month) == 1) {
            $month = "0" . $month;
        }
        if (strlen($date) == 1) {
            $date = "0" . $date;
        }

        $date_str = $year . $month . $date;
        return $date_str;
    }

    public function adjastDate($year, $month, $date)
    {
        switch ($month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                if ($date >= 32) {
                    $date = $date % 31;
                    $month += 1;
                }
                break;
            case 2:
                if ($year % 4 == 0) {
                    $date = $date % 29;
                    $date += 1;
                    $month += 1;
                } else {
                    $date = $date % 28;
                    $month += 1;
                }
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                if ($date >= 31) {
                    $date = $date % 30;
                    $month += 1;
                }
                break;
        }
        return [$month, $date];
    }

    public function getDate()
    {
        date_default_timezone_set('Asia/Tokyo');
        $year = date("Y");
        $month = date("m");
        $day = date("d");

        return [$year, $month, $day];
    }

    public function createUser($username, $email, $password)
    {
        $email_confirm_sql = "SELECT * FROM user WHERE MAILADDRESS = '$email';";
        $confirm_rows = $this->conn->query($email_confirm_sql);

        // if (!$confirm_rows) {
        //     trigger_error('Invalid query: ' . $this->conn->error);
        // }

        $date = $this->getDate();
        $date_var = $date[0] . "/" . $date[1] . "/" . $date[2];

        if ($confirm_rows->num_rows == 0) {
            $insert_sql = "INSERT INTO user(`USER_NAME`,MAILADDRESS,`password`,BALANCE,LOGIN_DAY) VALUES('$username','$email','$password',1000,'$date_var');";
            if ($this->conn->query($insert_sql)) {

                $sql = "SELECT * FROM user WHERE `MAILADDRESS` = \"$email\"";
                $result = $this->conn->query($sql);
                $result_a = $result->fetch_assoc();
                $id = $result_a['USER_ID'];
                $sql_2 = "INSERT INTO blanceofpayments(`USER_ID`,`SERVICE`,REFUND,BALANCE) VALUES ($id,'アカウント制作ボーナス',1000,1000);";
                $this->conn->query($sql_2);
                //user informations into session
                session_start();
                $_SESSION['id'] = $result_a['USER_ID'];
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['balance'] = 1000;

                header('Location: ../' . $_SESSION['URL']);
                exit();
            }
        } else {
            header('Location: ../contact.php?err=1');
            exit();
        }
    }

    public function getRaceInformations($race_id)
    {
        $sql = "SELECT * FROM race_order WHERE race_number = '$race_id' ORDER BY HORSE_NUMBER;";
        $result = $this->conn->query($sql);

        $race_name_list = new ArrayObject();

        while ($race_name = $result->fetch_assoc()) {
            $race_name_list->append($race_name);
        }

        // 出馬する馬を配列に格納
        $horse_name_array = new ArrayObject();
        for ($i = 0; $i < count($race_name_list); $i++) {
            $horse_name_array->append($race_name_list[$i]['HORSE_NAME']);
        }

        //騎手を配列に格納
        $jockey_number_array = new ArrayObject();

        for ($i = 0; $i < count($race_name_list); $i++) {
            $jockey_number_array->append($race_name_list[$i]['JOCKEY_NUMBER']);
        }


        $rank_array = new ArrayObject();
        for ($i = 0; $i < count($race_name_list); $i++) {
            $horse_name = "HORSE_NAME_" . (string)$horse_name_array[$i];
            $sql = "SELECT ID FROM aiexpect WHERE `data` = '$horse_name';";
            $result = $this->conn->query($sql);

            $result_fetch = $result->fetch_assoc();
            $rank_array->append($result_fetch['ID']);
        }

        $sql_drop = "TRUNCATE `mango`.`temp`;";
        $this->conn->query($sql_drop);

        for ($j = 0; $j < count($race_name_list); $j++) {
            $ai = (int)$rank_array[$j];
            $sql_4 = "INSERT INTO `temp` (id,RACE_NUMBER,RACEORDER_NUMBER,HORSE_NAME,ADD_WEIGHT,JOCKEY_NUMBER,RACE_TIME,MARGIN,FRAME_NUMBER,HORSE_NUMBER,ENDUP,HORSE_AGE,HORSE_WEIGHT,H_WEIGHT_INDECREASE,AIEXPECT) VALUES (" . $race_name_list[$j]['id'] . "," . $race_name_list[$j]['RACE_NUMBER'] . ",'" . $race_name_list[$j]['RACEORDER_NUMBER'] . "','" . $race_name_list[$j]['HORSE_NAME'] . "','" . $race_name_list[$j]['ADD_WEIGHT'] . "','" . $race_name_list[$j]['JOCKEY_NUMBER'] . "','" . $race_name_list[$j]['RACE_TIME'] . "','" . $race_name_list[$j]['MARGIN'] . "','" . $race_name_list[$j]['FRAME_NUMBER'] . "'," . $race_name_list[$j]['HORSE_NUMBER'] . ",'" . $race_name_list[$j]['ENDUP'] . "','" . $race_name_list[$j]['HORSE_AGE'] . "','" . $race_name_list[$j]['HORSE_WEIGHT'] . "','" . $race_name_list[$j]['H_WEIGHT_INDECREASE'] . "','$ai');";

            $this->conn->query($sql_4);
        }

        $sql_last = "SELECT * FROM `temp` WHERE RACE_NUMBER = $race_id ORDER BY AIEXPECT DESC;";
        $result_5 = $this->conn->query($sql_last);

        $race_info_result = new ArrayObject();

        while ($race_array = $result_5->fetch_assoc()) {
            $race_info_result->append($race_array);
        }

        return $race_info_result;
    }

    public function extractRace($id)
    {
        $sql = "SELECT * FROM race_list WHERE id = $id;";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function Confirmation($contents)
    {
        var_dump($contents);
        die();
    }

    public function getFastHorse($race_name)
    {
        $sql = "SELECT * FROM race_order WHERE race_number IN (select id from race_list where name LIKE '%$race_name%' ) AND RACE_TIME != '0' order by race_time;";
        $result = $this->conn->query($sql);

        $race_record = new ArrayObject();

        while ($race_array = $result->fetch_assoc()) {
            $race_record->append($race_array);
        }
        return $race_record;
    }

    public function getRaceDate($race_id)
    {
        $sql = "SELECT * FROM race_list WHERE id = $race_id;";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function Login($email, $passwd)
    {
        $sql = "SELECT * FROM user WHERE MAILADDRESS = '$email'";
        $result = $this->conn->query($sql);
        //メールアドレスが1つ以上登録されているとエラーを返す
        if ($result->num_rows == 1) {
            $user_details = $result->fetch_assoc();

            if (password_verify($passwd, $user_details['PASSWORD'])) {
                session_start();
                $_SESSION['id'] = $user_details['USER_ID'];
                $_SESSION['username'] = $user_details['USER_NAME'];
                $_SESSION['email'] = $user_details['MAILADDRESS'];
                $_SESSION['balance'] = $user_details['BALANCE'];


                $this->ConfBounus($_SESSION['id']);

                header("Location: ../" . $_SESSION['URL']);
                exit;
            } else {
                header("Location: ../login.php?err=1");
                exit;
            }
        } else if ($result->num_rows == 0) {
            header("Location: ../login.php?err=2");
            exit;
        } else if ($result->num_rows > 1) {
            header("Location: ../login.php?err=99");
            exit;
        }
        $this->conn->error;

        exit;
    }
    public function getPayment($user_id)
    {
        $sql = "SELECT * FROM blanceofpayments WHERE `USER_ID` = $user_id ORDER BY ID DESC LIMIT 5";
        $result = $this->conn->query($sql);
        $result_list = new ArrayObject();

        while ($list = $result->fetch_assoc()) {
            $result_list->append($list);
        }
        return $result_list;
    }

    public function ConfBounus($id)
    {
        $sql = "SELECT * FROM user WHERE `USER_ID` = $id;";
        $result = $this->conn->query($sql);
        $result_fetch = $result->fetch_assoc();
        $year = substr($result_fetch['LOGIN_DAY'], 0, 4);
        $month = substr($result_fetch['LOGIN_DAY'], 5, 2);
        $date = substr($result_fetch['LOGIN_DAY'], 8, 2);

        if ($year < $_SESSION['year'] || $year == $_SESSION['year']) {
            if ($month < $_SESSION['month'] || $month == $_SESSION['month']) {
                if ($date < $_SESSION['date']) {
                    $this->Bounus($_SESSION['id']);
                }
            }
        }
    }

    public function Bounus($id)
    {
        //user表のbalanceに1000(ログインボーナス)を加算する
        $sql = "UPDATE user set BALANCE = BALANCE + 1000 WHERE `USER_ID` = $id;";
        $this->conn->query($sql);

        //現在のbalanceを取得するSQL文
        $sql = "SELECT * FROM user WHERE `USER_ID` = $id";
        $result = $this->conn->query($sql);
        $result_list = $result->fetch_assoc();

        //user表のログインの日付を変更
        $date = $this->getDate();
        $date_var = $date[0] . "-" . $date[1] . "-" . $date[2];
        $update_sql = "UPDATE user set `LOGIN_DAY`='$date_var' WHERE `USER_ID` = $id ;";

        if (!$this->conn->query($update_sql)) {
            $this->Confirmation('error1');
        }


        $_SESSOIN['balance'] = $result_list['BALANCE'];
        $balance = $result_list['BALANCE'];

        $sql2 = "INSERT INTO blanceofpayments (`USER_ID`,REFUND,`SERVICE`,BALANCE) VALUES ($id,1000,'ログインボーナス',$balance);";

        if (!$this->conn->query($sql2)) {
            $this->Confirmation('error2');
        }
    }

    public function getBalance($id)
    {
        $sql = "SELECT BALANCE FROM user WHERE `USER_ID` = $id;";
        $result = $this->conn->query($sql);
        $result_index = $result->fetch_assoc();
        return $result_index;
    }

    public function getTansyou($race_id)
    {
        $sql = "SELECT * FROM `temp` WHERE RACE_NUMBER = $race_id ORDER BY AIEXPECT LIMIT 1;";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getWaku($id)
    {
        $sql = "SELECT * FROM `temp` WHERE RACE_NUMBER = $id ORDER BY AIEXPECT LIMIT 5;";
        $result = $this->conn->query($sql);
        $result_array = new ArrayObject();

        while ($index = $result->fetch_assoc()) {
            $result_array->append($index);
        }
        return $result_array;
    }

    public function getSanren($id)
    {
        $sql = "SELECT * FROM `temp` WHERE RACE_NUMBER = $id ORDER BY AIEXPECT LIMIT 3;";
        $result = $this->conn->query($sql);
        $result_array = new ArrayObject();

        while ($index = $result->fetch_assoc()) {
            $result_array->append($index);
        }
        return $result_array;
        
    }

    public function getSantan($id)
    {
        $sql = "SELECT * FROM `temp` WHERE RACE_NUMBER = $id ORDER BY AIEXPECT LIMIT 3;";
        $result = $this->conn->query($sql);
        $result_array = new ArrayObject();

        while ($index = $result->fetch_assoc()) {
            $result_array->append($index);
        }
        return $result_array;
    }
}
