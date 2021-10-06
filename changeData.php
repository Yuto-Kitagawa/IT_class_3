<?php
// include "../classes/functions.php";
// class ChangeData extends Database
// {
//     public function changeFormat()
//     {
//         for ($i = 1; $i <= 140; $i++) {
//             $sql = "SELECT date FROM race_list WHERE id = $i;";
//             $result = $this->conn->query($sql);
//             $result = $result->fetch_assoc();
//             $result = implode($result);
//             $date_array = explode("-", $result);
//             $new_date_str = implode($date_array);
//             echo $new_date_str;
//             $sql2 = "UPDATE race_list SET date = $new_date_str WHERE id = $i;";
//             $this->conn->query($sql2);
//         }

//         echo "変更完了";
//     }
// }
