<?
session_start();

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
	$_SESSION["no"] = $arr[no];
	$_SESSION["id"] = $arr[email];
	$_SESSION["nick"] = $arr[nickname];

	//마지막 접속일 갱신
	$loginTime = date("Y-m-d H:i:s",time());
	mysqli_query($connect,"update dg_member set last='{$loginTime}' where email='{$arr[email]}';") or die("update dg_member set last='{$loginTime}' where email='{$arr[email]}';");

}
else
	die("입력하신 아이디 또는 비밀번호가 올바르지 않습니다.");


die("1");
?>


