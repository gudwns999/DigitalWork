<?
session_start();

//로그인한 계정만 공방을 만들 수 있다.
if(!$_SESSION[id])
	die("로그인 후 이용 가능합니다.");

$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

$_POST=array_map('mres',$_POST);

$tstep = Array();
$tmember = Array();
parse_str($_POST[step],$tstep);
parse_str($_POST[member],$tmember);

$no = 0;
if($_POST[no])
{
	if($_SESSION[modno] != $_POST[no])
		die("올바르지 않은 시도입니다.");
	else
	{
		$no = intval($_SESSION[modno]);
	}
}
$name = $_POST[name];
$description = $_POST[description];
$type = $_POST[type];
$step = $tstep[step];
$member = $tmember[members];
$fromDate = $_POST[fromDate];	//시작일
$toDate = $_POST[toDate];		//종료일

if(mb_strlen($name) < 2 || mb_strlen($name) > 20) die("공방의 이름은 2~20자로 해주세요.");

if(mb_strlen($description) > 200) die("프로젝트의 설명은 200자 이내로 작성해 주세요.");


if(!mb_strlen($type)) die("프로젝트 유형을 지정해 주세요.");

if(mb_strlen($type) > 15) die("프로젝트 유형은 15자 이내로 작성해 주세요.");

if( !count($step) ) die("최소 1개의 프로젝트 단계가 필요합니다.");


for($i = 0; $i<count($step); $i++)
{
	if(mb_strlen($step[$i]) > 15) die("프로젝트 단계 중 ".($i+1)."단계의 이름을 15자 이내로 작성해 주세요.");
}


for($i = 0; $i<count($member); $i++)
{
	$ret = mysqli_fetch_array(mysqli_query($connect, "select nickname from dg_member where nickname='{$member[$i]}'"),MYSQLI_BOTH);
	
	if(!count($ret))
	{
		die("{$member[$i]} 님은 존재하지 않는 회원입니다.");
	}
}

if(!strlen($fromDate)) $fromDate = "";
if(!strlen($toDate)) $toDate = "";


if(strlen($fromDate) > 0 && strlen($toDate) > 0)
{
	if(date($fromDate) > date($toDate))
		die("시작일은 종료일보다 앞의 날짜여야 합니다.");
}

if($_POST[mod] == 1)
{
	$query = "update dg_workshop set name='{$name}',description='{$description}',type='{$type}',master='{$_SESSION[id]}',fromdate='{$fromDate}',toDate='{$toDate}',process_cnt=".count($step)." where no={$no}";
	mysqli_query($connect, "delete from dg_workshop_process where workshop_no={$no}");
}
else
{
	//공방 테이블에 삽입할 쿼리
	$query = "insert into dg_workshop(name, description, type, master, fromdate, todate, member_cnt, process_cnt) values('{$name}', '{$description}', '{$type}', '{$_SESSION[id]}', '{$fromDate}', '{$toDate}', 1, ".count($step).");";
}
mysqli_query($connect, $query);

if($_POST[mod]==1)
{
	$tmp = "select no from dg_workshop where no={$no}";
	$ret = mysqli_fetch_array(mysqli_query($connect, $tmp), MYSQLI_BOTH);
}
else
{
	$tmp = "select no from dg_workshop order by no desc limit 0,1";
	$ret = mysqli_fetch_array(mysqli_query($connect, $tmp), MYSQLI_BOTH);
}


//각 단계 추가
for($i = 0; $i < count($step); $i ++)
{
	$pno = $i + 1;
	$query = "insert dg_workshop_process(workshop_no, process_no, name) values({$ret[no]}, {$pno}, '{$step[$i]}');";
	mysqli_query($connect, $query);
}

//마스터는 멤버에 추가한다.

if($_POST[mod] != 1)
{
	$masterno = mysqli_fetch_array(mysqli_query($connect, "select no from dg_member where email='{$_SESSION[id]}'"),MYSQLI_BOTH);

	mysqli_query($connect, "insert dg_workshop_member(workshop_no, member_no) values({$ret[no]}, {$masterno[no]})");
}
//나머지 멤버에게는 초대를 한다.

for($i = 0; $i < count($member); $i++)
{
	$memberNo = mysqli_fetch_array(mysqli_query($connect, "select no from dg_member where nickname='{$member[$i]}'"), MYSQLI_BOTH);

	//마스터에게는 초대장을 보내지 않는다.
	if($memberNo[no] == $masterno[no]) continue;

	//이미 초대된 멤버에게는 중복된 초대장을 보내지 않는다.
	$chk = mysqli_fetch_array(mysqli_query($connect, "select * from dg_member_invite where no={$memberNo[no]} and workshop_no={$ret[no]}"), MYSQLI_BOTH);

	if(count($chk) > 0) continue;

	//초대된 적 없다면 초대장을 전송한다.
	mysqli_query($connect, "insert dg_member_invite(member_no, workshop_no, accepted) values({$memberNo[no]}, {$ret[no]}, 0);");
}

die("1");

function mres($a)
{
	global $connect;
	for($i=0; $i<count($a); $i++)
	{
		$a[$i] = mysqli_real_escape_string($connect, $a[$i]);
	}
	return $a;
}
?>