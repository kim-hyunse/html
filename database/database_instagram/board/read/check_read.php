<?php
    include "../db_info.php";
?>
<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>
<?php
    $bno = $_GET['idx']; /* bno함수에 idx값을 받아와 넣음*/
?>

<form action="check_read_ok.php?idx=<?php echo $bno ?>" method="POST">
    <p>비밀번호<input type="password" name="pw" />
    <input type="submit" value="확인" /></p>
</form>
<a href="../index.php">[목록으로]</a>