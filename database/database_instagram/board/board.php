<?php
    include "../db_info.php";
?>

<?php
    session_save_path("../session");
    session_start();
    if(isset($_SESSION['ID'])){
        $ID=$_SESSION['ID'];
    } else{
        echo "<script>alert('로그인을 하고 JARVIS의 서비스를 즐기세요!');</script>";
        echo "<script>location.href='../login/login.html'</script>";
    }
?>

<head>
<meta charset="utf-8">
<title>JARVIS</title>
<style>
    h1 {text-align: center;}
</style>
</head>
<body>
<div id = "sticky">
  <h1 class = "headline">JARVIS MAIN PAGE</h1>
</div>  
<table class="article_list" style="height: auto; width: 100%;">
    <?php
        $sql = "SELECT * FROM message WHERE parent_message is null ORDER BY message_id";
        $result1 = sq($sql);
        while($board=mysqli_fetch_array($result1)){
            $content=$board['content'];
            if(strlen($content) > 100){
                //content가 100자를 넘어가면 ...표시
                $content=str_replace($board["content"],mb_substr($board["content"],0, 100,"utf-8")."...", $board['content']);
            }
    ?>
    <tbody>
    <tr>
    <td style="border: 1px solid rgb(123, 186, 209); text-align: center; border-radius: 0.5rem;">
        <?php
            $href="./read/read.php?id=".$board['message_id'];
        ?>
        <a href="<?php echo $href ?>"><?php echo $content;?></a>
    </td>
    </tr>
    </tbody>
    <?php } ?>
</table>
<footer class = "find-btn" , id="footer">
    <from><input type = 'button' value = '로그아웃' style="float: left;" onclick="location.href='../logout/logout.php'"></from>
    <from><input type ='button' value = '글쓰기' style="float:right" onclick="location.href='./write/write.php'"></from>
</footer>
</body>
