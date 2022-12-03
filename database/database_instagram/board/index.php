<?php
    include "../db_info.php";
?>
<head>
<meta charset="UTF-8">
<title>게시판</title>
<link rel="stylesheet" type="text/css" href="./css/index.css?v=<?php echo date("Y-m-d H:i:s",time());?>">
</head>
<body>
    <div id="board_area"> 
    <h1>자유게시판</h1>
    <h4>자유롭게 글을 쓸 수 있는 게시판입니다.</h4>

    <table class="list-table">
        <thead>
            <tr>
                <th width="70">번호</th>
                <th width="500">제목</th>
                <th width="120">글쓴이</th>
                <th width="100">작성일</th>
                <th width="100">조회수</th>
            </tr>
        </thead>
        <?php
            $sql = "SELECT * FROM `message` ORDER BY message_id DESC";
            $result = sq($sql); 
            while($board = mysqli_fetch_array($result)) {
                //title변수에 DB에서 가져온 title을 선택
                $title = $board["title"];
                if(strlen($title) > 30) { 
                    //title이 30을 넘어서면 ...표시
                    $title = str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...", $board["title"]);
                }
        ?>
        <tbody>
            <tr>
                <?php
                    $lock_img = "<img class=\"lock\" src=\"./img/lock.png\" alt=\"lock\" />";
                ?>
                <td width="70">
                    <?php echo $board["idx"];?>
                </td>
                <td width="500">
                    <?php
                        if($board["lock_post"] == 0) {
                            $href = "./read/read.php?idx=".$board["idx"];
                        } else {
                            $href = "./read/check_read.php?idx=".$board["idx"];
                        }
                    ?>
                    <a href="<?php echo $href ?>"><?php echo $title;?></a>
                <?php
                    if($board["lock_post"] == 1) {
                        echo $lock_img;
                    }
                ?>
                </td>
                <td width="120"><?php echo $board["name"];?></td>
                <td width="100"><?php echo $board["date"];?></td>
                <td width="100"><?php echo $board["hit"];?></td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
    <div id="write_btn">
        <a href="./write/write.php">
            <button>글쓰기</button>
        </a>
    </div>
</body>
</html>