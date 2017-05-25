<?
header("Content-Type: text/html; charset= UTF-8 ");

$flag = $_POST['image'];
if( !isset($flag) ) {
    exit("삭제할 파일이 존재하지 않음.");
}//if

$filename = $flag;
$write_del=$_POST['write_del'];

//DB연결
$db = @new mysqli('localhost','capstone','zoqtmxhs','capstone');
if(mysqli_connect_errno()) {
    exit("DB연결오류");
}//if

//존재하는 이미지 파일인가를 체크
$query = "SELECT * FROM dg_file_list WHERE db_filename='$filename'";
$result = $db->query($query);
if($result->num_rows < 1) {
    echo "".$filename;
    exit("이미지 파일 존재 안함");
}//if

//이미지 정보 가져오기
$row = $result->fetch_assoc();
$db_filename = $row['db_filename'];
$upload_filename = $row['upload_filename'];
$file_path = $row['file_path'];

//오토커밋모드 해제
$db->autocommit(false);

//DB에서 해당파일 정보삭제
$query = "DELETE FROM dg_file_list WHERE db_filename = '$flag'";
$query2 = "DELETE FROM dg_write WHERE write_no = '$write_del'";
$db->query($query);
$db->commit();
/*
if($db->affected_rows < 1) {
    exit("DB에 이미지 정보가 없음");
}

//실제 파일 존재여부 체크
if(!is_file($file_path.'/'.$db_filename)) {
    exit("이미지 파일이 존재하지 않음");
}

//파일 삭제
if(unlink($file_path.'/'.$db_filename)) {
    $db->commit();
    echo "<script>alert('파일삭제 완료');</script>";
}else{
    $db->rollback();
    echo "<script>alert('파일삭제 실패');</script>";
}
*/
$db->query($query2);
#$db->commit();

if($db->affected_rows < 1) {
    exit("DB에 이미지 정보가 없음");
}

//실제 파일 존재여부 체크
if(!is_file($file_path.'/'.$db_filename)) {
    exit("이미지 파일이 존재하지 않음");
}

//파일 삭제
if(unlink($file_path.'/'.$db_filename)) {
    $db->commit();
    echo "<script>alert('파일삭제 완료');</script>";
}else{
    $db->rollback();
    echo "<script>alert('파일삭제 실패');</script>";
}echo ("<meta http-equiv='Refresh' content='1; URL=make.php'>");
?>



<!--삭제 처리후 이동할 페이지 지정-->
<!--<script>location.href='image_list.php';</script>-->