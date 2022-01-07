<!-- <!-- $num 지역
$_num 전역 -->
<?php

session_start();

include('DB.php');

if(isset($_POST['user_id']) && isset($_POST['pass1']))
{
    // 보안강화
   $user_id = mysqli_real_escape_string($db,$_POST['user_id']);
   $pass1 = mysqli_real_escape_string($db,$_POST['pass1']);

   if(empty($user_id))
    {
        header("location: login_view.php?error=아이디가 입력되지 않았습니다.");
        exit();
    }

    else if(empty($pass1))
   {
       header("location: login_view.php?error=비밀번호가 비어있어요");
       exit();
    }


    else
    {

        $sql = "select * from member where mb_id = '$user_id'"; 
        $result = mysqli_query($db,$sql); 
        
        
        if(mysqli_num_rows($result) === 1) 
        {
            // 1. 해당열 가지고오기
            // 2. 배열 형태로 가져오기
            // 3. print_r 배열을 출력해주는 함수
            // 4. echo 쪼개서 가져오기
            $row = mysqli_fetch_assoc($result);
            $hash = $row['password'];
            
            if(password_verify($pass1,$hash))
            {
                $_SESSION['no'] = $row['no'];
                $_SESSION['mb_id'] = $row['mb_id'];
                $_SESSION['mb_nick'] = $row['mb_nick'];
                $_SESSION['mb_password'] = $row['mb_password'];
                header("location: mypage/mypage.php");
                exit();
            }
            else
            {
                header("location: login_view.php?error=비밀번호가 틀립니다.");
                exit();
            }
        }
        else
        {
            header("location: login_view.php?error=등록된 아이디가 없습니다.");
            exit();
        }
    }


}

else
{
    header("location: login_view.php?error=관리자에게 문의해주세요.");
    exit();
}
//컨트롤 h 레전드 바꿔줌

?>