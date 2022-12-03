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

<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
?>
<?php
    $parent_message_id = $_GET['id'];
    $commenter_id = $ID;
    $content = $_POST['comment_input'];
    $timestamp = date("Y-m-d H:i:s",time());
    
    if($parent_message_id && $commenter_id && $content && $timestamp) {
        $sql = "INSERT INTO message(writer_id, content, parent_message, message_time)
                          values('".$commenter_id."','".$content."','".$parent_message_id."','".$timestamp."')";
        $result=sq($sql);
        echo "<script>
                alert('댓글이 작성되었습니다.'); 
                location.href='./read.php?id=$parent_message_id';
              </script>";
     }else {
        echo "<script>
                alert('댓글 작성에 실패했습니다.'); 
                history.back();
              </script>";
    }
	
?>