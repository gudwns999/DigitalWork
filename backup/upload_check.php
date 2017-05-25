<?
#아이디 가져오기
session_start();
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");
if(!$connect)
{
	die("DB 접속 오류입니다. 다시 시도해 주세요.");
}

$_POST=array_map('mres',$_POST);

$arr = mysqli_fetch_array(mysqli_query($connect,"SELECT no FROM dg_member WHERE email='{$_SESSION[id]}'"),MYSQLI_BOTH);
$member_no = $arr['no'];
$write_name = $_POST['write_name'];
$write_description = $_POST['write_description'];
$process_no = $_POST['process_no'];
$workshop_no = $_POST['workshop_no'];
$arr1 = mysqli_fetch_array(mysqli_query($connect,"SELECT no,name FROM dg_workshop WHERE no='$workshop_no'"),MYSQLI_BOTH);
$project_name = $arr1['name'];
$project_no = $arr1['no'];
#--------------------------------------------------
#이미지 DB에 박기

//1. 업로드 파일 존재여부 확인
if (!isset($_FILES['upload']))
{
	alert("파일을 업로드 해주세요.");
}

//2. 업로드 오류여부 확인
//
if ($_FILES['upload']['error'] > 0)
{
	alert("파일 첨부 도중 오류가 발생했습니다. 관리자에게 문의해 주세요. 에러코드 : ".$_FILES['upload']['error']);
}

if(mb_strlen($write_name) == 0)
	alert("제목 입력은 필수입니다.");

if(mb_strlen($write_description) == 0)
	alert("설명 입력은 필수입니다.");

$write_description = preg_replace("#(\\r\\n|\\r|\\n)#",'<br/>',$write_description);




//4. 업로드 허용 확장자 체크(보편적인 jpg,jpeg,gif,png,bmp 확장자만 필터링)
$ableExt = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'stl', 'psd', 'ai', 'stl');
$path = pathinfo($_FILES['upload']['name']);
$ext = strtolower($path['extension']);
if (!in_array($ext, $ableExt))
	alert("현재 지원하지 않는 확장자입니다. 관리자에게 문의해 주세요.");

$upload_filename = $connect->real_escape_string($_FILES['upload']['name']);
$file_size = $_FILES['upload']['size'];
$file_type = $_FILES['upload']['type'];
$upload_date = date("Y-m-d H:i:s");

//테이블에 올리기 전 테이블의 auto_increment 값을 가져온다. 이 값이 write_no가 된다.(2016-04-04)

if($_GET[u] != "1"){

$query = "select auto_increment from information_schema.tables where table_name = 'dg_write' and table_schema = DATABASE();";
$arr2 = mysqli_fetch_array(mysqli_query($connect,$query),MYSQLI_BOTH);

$parent_no = $arr2["auto_increment"];

}

if($_POST['update'] == "0")
{

	//게시글 정보 저장
	mysqli_query($connect,"INSERT INTO dg_write (workshop_no,member_no,process_no) VALUES ('{$workshop_no}','{$member_no}','{$process_no}')");

	//첨부파일 정보 저장
	mysqli_query($connect,"INSERT INTO dg_file_list(workshop_no,parent_no,upload_date,file_type,file_size,title,description,upload_filename,file_ver) VALUES ('{$workshop_no}','{$parent_no}','{$upload_date}','{$file_type}','{$file_size}','{$write_name}','{$write_description}','{$upload_filename}',10)");
}
else
{
	//현재 수정할 대상의 정보를 먼저 읽어 온다.
	$query2 = mysqli_query($connect,"select parent_no,file_ver from dg_file_list where workshop_no = {$_POST[workshop_no]} and parent_no = {$_POST[target]} order by file_ver desc limit 0,1");
	$version = mysqli_fetch_array($query2,MYSQLI_BOTH);

	$parent_no = $version[parent_no];
	$nextVersion = intval($version[file_ver]) + 1;

	//첨부파일 정보만 업데이트한다.
	mysqli_query($connect,"INSERT INTO dg_file_list(workshop_no,parent_no,upload_date,file_type,file_size,title,description,upload_filename,file_ver) VALUES ('{$workshop_no}','{$parent_no}','{$upload_date}','{$file_type}','{$file_size}','{$write_name}','{$write_description}','{$upload_filename}',{$nextVersion})");

}

//파일 실제 저장을 위한 작업 시작.

/***************************************
이미지 파일 로드 방식
이미지 파일은 image_view.php의 wno(workshop_no), fno(file_no)를 통해 이루어진다.
폴더 경로 방식은 {공방번호의 hash}/게시글번호/버전/파일이름이다.
해쉬방식은 md5("dg".공방번호);
파일 이름에 mysqli_real_escape_string 을 하면 \ 때문에 파일이 생성되지 않는다.
따라서 파일이름 역시 hash 한다. 파일을 다운로드 할 때는 게시글번호/버전 에 들어있는 파일을 다운로드 시키면된다.(1개밖에 없기 떄문)
***************************************/

$version = $_POST[update] == "0"? 10 : $nextVersion;
$folderName = "img/workshop/".md5("dg".$project_no)."/".$parent_no."/".$version;

$imgName = md5($upload_filename);



//디렉토리가 없을 경우 디렉토리 생성
if(!is_dir($folderName))
{
	mkdir($folderName,0777,true) or die("에러");
}
move_uploaded_file($_FILES['upload']['tmp_name'], $folderName."/".$imgName);

if($_GET[u] == "0")
	complete($project_no);
else
	complete($_POST[workshop_no]);
function mres($a)
{
	global $connect;
	return mysqli_real_escape_string($connect,$a);
}

function alert($s)
{
	die("<script>alert('{$s}'); history.back();</script>");
}

function complete($no)
{
	die("<script>alert('성공적으로 업로드 되었습니다.'); location.href = 'make.php?no={$no}';</script>");
}
?>