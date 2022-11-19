<?php
    include "../db_info.php";
?>
<?php
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );
?>
<?php
    $ID = $_POST['ID'];
    $PW1 = $_POST['password1'];
    $PW2 = $_POST['password2'];
    $NICKNAME = $_POST['nickname'];
    $LOCATION = $_POST['location'];
    $BIRTHDAY = $_POST['birthday'];
    
    if($PW1 == $PW2) {
        $sql1 = "SELECT * FROM user WHERE `user_id` = '" . $ID . "'";
        $result1 = sq($sql1);
        $row_count1 = mysqli_num_rows($result1);

        if($row_count1 == 0) {
            $sql2 = "INSERT INTO user(`user_id`, user_pw, nickname, `location`, birthday) 
            VALUES('" . $ID .  "','" . $PW1 . "', '" . $NICKNAME . "', '" . $LOCATION . "', '" . $BIRTHDAY . "')";
            $result2 = sq($sql2);
            echo $result2;
            echo "<script>alert('SUCCESS'); location.href=\"../login/login.html\"</script>";
        } else {
            echo "<script>alert('FAIL : Already same ID'); history.back();</script>";
        }
    } else {
        echo "<script>alert('FAIL : Password different'); history.back();</script>";
    }
?>

<script>
</script>