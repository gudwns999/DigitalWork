<?

session_start();
if($_POST)
{
	//die(session_id());
	//DB 접속
	$id = $_POST[loginid];
	$nickname = $POST[name];
	$pwd = $_POST[loginpwd];

	$pwd = hash('sha256', $pwd);

	$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
	mysqli_query($connect, "set names utf8");

	$id = mysqli_real_escape_string($connect, $id);
	$pwd = mysqli_real_escape_string($connect, $pwd);

	if(!preg_match("/^[0-9a-zA-Z]([\-.\w]*[0-9a-zA-Z\-_+])*@([0-9a-zA-Z][\-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}$/si",$id))
	{
		die("이메일 형식이 올바르지 않습니다.");   
	}

	$query = mysqli_query($connect, "select * from dg_member where email='".$id."' and password='".$pwd."';");


	//테이블에서 가져온 값울 배열로 변환
	if($arr = mysqli_fetch_array($query,MYSQLI_BOTH))
	{
		$_SESSION["no"] = $arr[mem_no];
		$_SESSION["id"] = $arr[email];
		$_SESSION["nick"] = $arr[nickname];

		//마지막 접속일 갱신
		$loginTime = date("Y-m-d H:i:s",time());
		mysqli_query($connect,"update dg_member set last='{$loginTime}' where email='{$arr[email]}';") or die("update dg_member set last='{$loginTime}' where email='{$arr[email]}';");

	}
	else
		die("입력하신 아이디 또는 비밀번호가 올바르지 않습니다.");

	$redirectPath = $_SESSION[go];
	unset($_SESSON[go]);
	header("Location:".$redirectPath);
}
?>
<?
$_SESSION[go] = $_GET[go];
?>
<!-- Modal -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 23px;
    margin: 4px 2px;
    cursor: pointer;
}

.button1 {border-radius: 8px; font-size: 5px;}
</style>

    <div class="rows" id="myModal" role="dialog" style="text-align:center;">
    <div class="dialog" style="display:inline-block;">

	  <form method="post">
      <div class="content">
        <div class="header">
          <h4 class="title" style="font-size:25px;">로그인</h4>
        </div>
		<br>
        <div class="body">
         <div class="form-group">
             <label for="email">  아이디</label>
           <input type="text" class="form-control" name="loginid" id="email" placeholder="가입하신 이메일을 입력하세요." >
          </div>
          <div class="form-group">
            <label for="pwd">비밀번호</label>
            <input type="password" class="form-control" name="loginpwd" id="pwd" placeholder="비밀번호를 입력하세요.">
          </div>
		  
        <center><button type="submit" class="button button1">로그인</button></center>
      
        </div>
		</form>  
		<br>
        <div class="footer">
			<label>회원이 아니시라면 지금 가입해 보세요!&nbsp;&nbsp;&nbsp;<button onclick="location.href='register.php'" type="button" class="button button1" data-dismiss="modal">회원가입</button></label><br>
        </div>
      </div>
    </div>
  </div>

  </head>
  </html>