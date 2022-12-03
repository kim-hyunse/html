<?php
    include "../../db_info.php";
?>

<?php
    session_save_path("../../session");
    session_start();
    if(isset($_SESSION['ID'])){
        $ID=$_SESSION['ID'];
    } else{
        echo "<script>alert('로그인을 하고 JARVIS의 서비스를 즐기세요!');</script>";
        echo "<script>location.href='../../login/login.html'</script>";
    }
?>

<head>
    <meta charset="UTF-8">
    <title>별글</title>
    <link rel="stylesheet" type="text/css" href="./css/write.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
</head>
<body>
    <?php
        $fet=mysqli_fetch_array(sq("SELECT nickname FROM `user` WHERE `user_id`='".$ID."'"));
        $writer_nickname=$fet['nickname'];
    ?>
    <div id="board_write">
        <h1><a href="../board.php">글 작성</a></h1>
        <h4>글을 작성하는 공간입니다.</h4>
            <div id="write_area">
                <form enctype="multipart/form-data" action="write_ok.php" method="post">

                    <!-- 보이지 않게 POST로 작성자의 ID 전달 -->
                    <input type="hidden" name="id" value="<?php echo $ID?>"/>

                    <div id="in_name">
                        <p name="name" id="uname" rows="1" cols="55" maxlength="100"><?php echo $writer_nickname; ?></p>
                    </div>
                    <div class="wi_line"></div>
                    <div id="in_content">
                        <textarea name="content" id="ucontent" placeholder="내용" required></textarea>
                    </div>

                    <!-- 사진 업로드 -->
                    <div><input name="image" type="file"/></div>
                    <div class="bt_se">
                        <button type="submit">글 작성</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>