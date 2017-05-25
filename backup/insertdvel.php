<?
#아이디 가져오기
session_start();
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");
if(!$connect) {
    exit("DB연결오류");
}
$url = $_POST['url'];
$write_order = $_POST['write_order'];
$workshop_no = $_POST['workshop_no'];
$write_no = $_POST['write_no'];
$project_name = $_POST['project_name'];
$file_ver = $_POST['file_ver'];
$process_no = $_POST['process_no'];
$upload_filename = $_POST['upload_filename'];
$write_name = $_POST['write_name'];
$write_description = $_POST['write_description'];

$query = mysqli_query($connect,"SELECT * FROM dg_member WHERE email='{$_SESSION[id]}'");
$arr = mysqli_fetch_array($query,MYSQLI_BOTH);
$member_no = $arr['no'];

#--------------------------------------------------
#이미지 DB에 박기

if($_POST['mode'] == 'upload') {
    //1. 업로드 파일 존재여부 확인
    if (!isset($_FILES['upload'])) {
        exit("업로드 파일 존재하지 않음");
    }

    //2. 업로드 오류여부 확인
    if ($_FILES['upload']['error'] > 0) {
        switch ($_FILES['upload']['error']) {
            case 1:
                exit("php.ini 파일의 upload_max_filesize 설정값을 초과함(업로드 최대용량 초과)");
            case 2:
                exit("Form에서 설정된 MAX_FILE_SIZE 설정값을 초과함(업로드 최대용량 초과)");
            case 3:
                exit("파일 일부만 업로드 됨");
            case 4:
                exit("업로드된 파일이 없음");
            case 6:
                exit("사용가능한 임시폴더가 없음");
            case 7:
                exit("디스크에 저장할수 없음");
            case 8:
                exit("파일 업로드가 중지됨");
            default:
                exit("시스템 오류가 발생");
        }
    }
    //3. 업로드 제한용량 체크(서버측에서 5M로 제한)
    if ($_FILES['upload']['size'] > 5242880) {
        exit("업로드 최대용량 초과");
    }//if
    //4. 업로드 허용 확장자 체크(보편적인 jpg,jpeg,gif,png,bmp 확장자만 필터링)
    $ableExt = array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'stl', 'psd', 'ai');
    $path = pathinfo($_FILES['upload']['name']);
    $ext = strtolower($path['extension']);
    if (!in_array($ext, $ableExt)) {
        exit("허용되지 않는 확장자입니다.");
    }
    //5. MIME를 통해 이미지파일만 허용(2차 확인)
    $ableImage = array('image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/gif', 'image/bmp', 'image/pjpeg');
    if (!in_array($_FILES['upload']['type'], $ableImage)) {
        exit("지정된 이미지만 허용됩니다.");
    }

    $file_size = $_FILES['upload']['size'];
    $file_type = $_FILES['upload']['type'];
    $upload_date = date("Y-m-d H:i:s");
    $query3 = mysqli_query($connect,"SELECT * FROM dg_write WHERE workshop_no='$workshop_no'  ORDER BY parent_no DESC ");
    $arr2 = mysqli_fetch_array($query2,MYSQLI_BOTH);
    $write_no = $arr2['write_no'];
    $query3 = mysqli_query($connect,"SELECT * FROM dg_file_list WHERE workshop_no='$workshop_no'  ORDER BY parent_no DESC ");
    $arr3 = mysqli_fetch_array($query3,MYSQLI_BOTH);
     $parent_no = $arr3['parent_no'];
    $query2 = mysqli_query($connect, "INSERT INTO dg_write (workshop_no,write_name,write_description,member_no,process_no) VALUES ('{$workshop_no}','{$write_name}','{$write_description}','{$member_no}','{$process_no}')");

      $query4 = mysqli_query($connect,"INSERT INTO dg_file_list(workshop_no,parent_no,upload_date,file_type,file_size,upload_filename,file_ver) VALUES ('{$workshop_no}','{$write_order}','{$upload_date}','{$file_type}','{$file_size}','{$upload_filename}','{$file_ver}')");
      $query5 = mysqli_query($connect,"SELECT * FROM dg_file_list where workshop_no = '$workshop_no' ORDER BY file_ver DESC LIMIT 1");
      $arr5 = mysqli_fetch_array($query5,MYSQLI_BOTH);
      $file_ver = $arr5['file_ver'];
      $file_ver += 0.1;
      // 해쉬값으로 폴더 찾고 하위 폴더 계속 생성.
      $hash = md5($no.$name); //공방 번호 + 공방이름 해쉬명으로 폴더 하나 만들고 하위 폴더로 /글 넘버/버전/파일
      $structure = './workshop/' . $hash . '/' . $write_order. '/'.$file_ver.'/';
      //중요 이미지의 경우 웹루트(www) 밖에 위치할 것을 권장(예제 편의상 아래와 같이 설정)
      $folder_path = 'workshop/' . $hash . '/' . $write_order. '/'.$file_ver.'/';
      $file_server_path = realpath(__FILE__);
      $file_path = str_replace(basename(__FILE__), "", $file_server_path.$folder_path);
      $url_path = "http://hae.so/capstone/".$folder_path;
      $query6 = mysqli_query($connect,"UPDATE dg_file_list SET file_path='$url_path', file_ver='$file_ver' WHERE workshop_no =$workshop_no ORDER BY file_no DESC LIMIT 1");
      //DB에 파일내용 저장 성공시
  //9. 업로드 파일을 새로 만든 파일명으로 변경 및 이동
      if(@mkdir($structure, 0777,true)) {
          if(is_dir($structure)) {
              @chmod($structure, 0777,true);
          }
      }
      else {
          echo "${structure} 이미있음.";
      }
      if (move_uploaded_file($_FILES['upload']['tmp_name'], "$file_path" . "$upload_filename")) {
          //10. 성공시 db저장 내용을 적용(커밋)
          echo "업로드 성공";
      } else {
          //실패시 db에 저장했던 내용 취소를 위한 롤백
          exit("업로드 실패");
      }

  // 새 글 쓰기인 경우 리스트로..
  echo ("<meta http-equiv='Refresh' content='1; URL=develope.php'>");


}
?>
<center>
    <font size=2>정상적으로 저장되었습니다.</font>
