<?
session_start();

$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

if(!$_SESSION[id]) {$email = "guest";$guest=1;}
else {$email = $_SESSION[id];$guest=0;}
if(!$_SESSION[nick]) $nickname = "손님";
else $nickname = $_SESSION[nick];
$token=md5(mb_convert_encoding("caps".$email."tone".$nickname,'UTF-8', 'UTF-8'));
$room = $_GET[no];
?>

var socket = io();
var id = "<?=$email?>";
var nick = "<?=$nickname?>";
var token = "<?=$token?>";
var room = <?=$room?>;

socket.on('auth',function()
{
	//계정 정보와 닉네임, 토큰, 현재 접속한 공방의 정보를 전송한다.
	socket.emit("send information",id,nick,token, room);
});

socket.on('greeting',function()
{	
	socket.emit("member list");
});

socket.on("subject",function(name,description)
{
	$('#workshopTitle').html(name+"<br><br><span style='font-size:13px;'>"+description+"</span>");
});

socket.on("subject error",function()
{
	alert("존재하지 않는 공방입니다.");
});


socket.on('invalid token',function()
{
	alert("올바르지 않은 정보입니다.");
	//history.back();
});

socket.on('receive member list',function(a)
{
	alert("받은 데이터 : "+a);
});

<?
header("Content-type: application/javascript");
?>