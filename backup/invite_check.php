<?
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

//조작된 값이 오는 경우
if($_GET) die("잘못된 시도입니다.");

$workshop_no = $_POST[workshop_no];
$member_no = $_POST[member_no];
$accepted = $_POST[accepted];
//$workno = $_POST[];

if($accepted == "true")
{
	//수락했으면 accepted 값 1로 바꿔준다.
	$sql = "update dg_member_invite set accepted=1 where workshop_no={$workshop_no} and member_no={$member_no};";
	mysqli_query($connect, $sql);

	//2016-04-03 초대 수락 시 멤버 테이블 추가
	$sql = "insert dg_workshop_member(workshop_no, member_no) values({$workshop_no},{$member_no});";
	mysqli_query($connect, $sql);
	die("1");
}
else
{
	$sql = "update dg_member_invite set accepted=2 where workshop_no={$workshop_no} and member_no={$member_no};";
	mysqli_query($connect, $sql);
	die("2");
}

?>

