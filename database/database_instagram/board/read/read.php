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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
</head>
<body>
    <?php
        $message_id=$_GET['id'];
        $fet=sq("UPDATE message SET hit=hit+1 WHERE message_id='".$message_id."'");
        $result=sq("SELECT message_id, nickname, content, hit, message_time FROM message NATURAL JOIN `user` 
                    WHERE `user_id`=`writer_id` AND message_id=$message_id");
        $article=$result->fetch_array();
    ?>
    <h2> <a href="../board.php">JARVIS</a></h2> 
	<div id="user">
	writer:<?php echo $article['nickname'];?>

	</div>
	<div id="article">	
		<div id="contents">

        <?php
            $image_query="SELECT `image` FROM `image` WHERE message_id=$message_id";

            //이미지를 결과값으로 받아와서 표시, 받아온 결과 이미지가 없을 경우 생략
            if($image_result=mysqli_fetch_array(sq($image_query))){
                echo '<img width="400" src="data:image/jpeg;base64,'.base64_encode( $image_result['image'] ).'"/>';
            }
            echo '<br>';
            echo $article['content']; 
        ?>
        
        </div>
	</div>
    <div id="form-commentInfo">
        <div id="comment-count">댓글 <span id="count">0</span></div>

        <!-- 댓글 입력창 -->
        <form action="./comment_ok.php?id=<?php echo $message_id;?>" method="POST">
            <input type="text" name="comment_input" id="comment-input" placeholder="댓글을 입력해 주세요.">
            <button type="submit">댓글 등록</button>
        </form>
    </div>
    <div id="comments">
        <?php
            $result=sq("SELECT message_id, nickname, writer_id, content, message_time FROM message NATURAL JOIN `user`
                        WHERE `user_id`=`writer_id` AND parent_message=$message_id ORDER BY message_id DESC");
            while($comments = $result->fetch_array()) {
        ?>
        <div>
			<b><?php echo $comments['nickname'];?></b>
			</div>
				<div><?php echo nl2br($comments['content']); ?></div>
				<div><?php echo $comments['message_time']; ?></div>
        <?php } ?>
    </div>

<script>
const inputBar = document.querySelector("#comment-input");
const rootDiv = document.querySelector("#comments");
const btn = document.querySelector("#submit");
const mainCommentCount = document.querySelector('#count'); //맨위 댓글 숫자 세는거.

//타임스템프 만들기
function generateTime(){
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth();
    const wDate = date.getDate();
    const hour = date.getHours();
    const min = date.getMinutes();
    const sec = date.getSeconds();

    const time = year+'-'+month+'-'+wDate+' '+hour+':'+min+':'+sec;
    return time;

}

//유저이름 발생기
//유저이름은 8글자로 제한.
function generateUserName(){
	/*<input type="text" id="test" value"abc">
	var x = document.getElementById("test").value;
	console.log(x)
	result::abc*/
	let alphabet='abcdefghijklmnopqrstuvwxyz'
	var makeUsername = '';
    for(let i=0; i<4;i++){
        let index = Math.floor(Math.random(10) * alphabet.length);
        makeUsername += alphabet[index];        
    }
    for(let j=0;j<4;j++){
        makeUsername += "*";
    }
    return makeUsername;    
}

function numberCount(event){
    console.log(event.target);
    if(event.target === voteUp){
        console.log("2");
      return voteUp.innerHTML++; 
      
    }else if(event.target === voteDown){
      return voteDown.innerHTML++; 
    }   
    
}

function deleteComments(event){    
    const btn = event.target;    
    const list = btn.parentNode.parentNode;//commentList
    rootDiv.removeChild(list);
    //메인댓글 카운트 줄이기.
    if(mainCommentCount.innerHTML <='0'){
        mainCommentCount.innerHTML = 0;
    }else{
        mainCommentCount.innerHTML--;
    }
}


//댓글보여주기
function showComment(comment){
    const userName = document.createElement('div');
    const inputValue = document.createElement('span');
    const showTime = document.createElement('div');
    const voteDiv = document.createElement('div');
    const countSpan = document.createElement('span')
    const voteUp = document.createElement('button');
    const voteDown = document.createElement('button');  
    const commentList = document.createElement('div');  //이놈이 스코프 밖으로 나가는 순간 하나지우면 다 지워지고 입력하면 리스트 다불러옴.
    //삭제버튼 만들기
    const delBtn = document.createElement('button');
    delBtn.className ="deleteComment";
    delBtn.innerHTML="삭제";
    commentList.className = "eachComment";
    userName.className="name";
    inputValue.className="inputValue";
    showTime.className="time";
    voteDiv.className="voteDiv";
    //유저네임가져오기 
    userName.innerHTML = generateUserName();    
    userName.appendChild(delBtn);  
    //입력값 넘기기
    inputValue.innerText = comment;
    //타임스템프찍기
    showTime.innerHTML = generateTime();
    countSpan.innerHTML=0;
    //투표창 만들기, css먼저 입혀야함.  
    voteUp.id = "voteUp";
    voteUp.innerHTML = '↑';    
    voteDown.id = "voteDown";
    voteDown.innerHTML = '↓';       
    voteDiv.appendChild(voteUp);
    voteDiv.appendChild(voteDown);

    //댓글뿌려주기       
    commentList.appendChild(userName);
    commentList.appendChild(inputValue);
    commentList.appendChild(showTime);
    commentList.appendChild(voteDiv);
    rootDiv.prepend(commentList);

    voteUp.addEventListener("click",numberCount);
    voteDown.addEventListener("click",numberCount);
    delBtn.addEventListener("click",deleteComments);
   console.dir(rootDiv);

}



//버튼만들기+입력값 전달
function pressBtn(){ 
   const currentVal = inputBar.value;
   
   if(!currentVal.length){
      alert("댓글을 입력해주세요!!");
   }else{
      showComment(currentVal);  
      mainCommentCount.innerHTML++;
      inputBar.value ='';
   }
}

btn.onclick = pressBtn;
</script>
</body>
</html>