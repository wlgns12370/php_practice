<!-- $num 지역
$_num 전역 -->
<?php

include('DB.php');

if(isset($_POST['user_id']) && isset($_POST['user_nick']) && isset($_POST['pass1']) && isset($_POST['pass2']))
{
    // 보안강화
   $user_id = mysqli_real_escape_string($db,$_POST['user_id']);
   $user_nick = mysqli_real_escape_string($db,$_POST['user_nick']);
   $pass1 = mysqli_real_escape_string($db,$_POST['pass1']);
   $pass2 = mysqli_real_escape_string($db,$_POST['pass2']);

   if(empty($user_id))
    {
        header("location: register_view.php?error=아이디가 입력되지 않았습니다.");
        exit();

        // echo "<script>
        // alert('아이디가 입력되지 않았습니다.');
        // history.back(); //흔적 있게 사이트로 덮는다
        // </script>";
    }
    else if(empty($user_nick))
   {
        header("location: register_view.php?error=닉네임이 입력되지 않았습니다.");
        exit();
        
        // echo "<script>
        // alert('아이디가 입력되지 않았습니다.');
        // location.replace('register_server.php'); //흔적 없이 사이트로 덮는다 이거를 많이 사용 
        // </script>";
    }
    else if(empty($pass1))
   {
       header("location: register_view.php?error=비밀번호가 비어있어요");
       exit();
    }
    else if(empty($pass2))
    {
        header("location: register_view.php?error=비밀번호가 비어있어요");
        exit();
    }
    else if($pass1 !== $pass2)
    {
        header("location: register_view.php?error=비밀번호가 일치하지 않아요");
        exit();
    }
    else
    {
        // $md5 = md5($pass1); //양방향 암호 단점 => 복호화 가능
        // echo $md5;
        
        // echo '<br>';
        
        $pass1 = password_hash($pass1 , PASSWORD_DEFAULT); //단방향 암호 
    
        //중복 체크

        $sql_same = "SELECT * FROM member where mb_id = '$user_id' and mb_nick = '$user_nick'";
        $order = mysqli_query($db,$sql_same); 
        
        if(mysqli_num_rows($order) > 0)
        {
            header("location: register_view.php?error=아이디 또는 닉네임이 존재합니다.");
            exit();
        }
        else
        {
            $sql_save = "insert into member(mb_id, mb_nick, password) values('$user_id','$user_id', '$pass1')";
            $result = mysqli_query($db, $sql_save);

            if($result)
            {
                header("location: register_view.php?success=성공적으로 가입 되었습니다.");
                exit();
            }
            else
            {
                header("location: register_view.php?error=가입에 실패하였습니다.");
                exit();
            }
        }

    }


}

else
{
    header("location: register_view.php?error=관리자에게 문의해주세요.");
    exit();
}

?>