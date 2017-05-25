<?//PHP 5.2.5, 작성: sysop@sexy.pe.kr
header("Content-Type: text/html; charset= UTF-8 ");
#이미지 삽입
//현재 업로드 상태인지를 체크
if($_POST['mode'] == 'upload') {
//1. 업로드 파일 존재여부 확인
    if(!isset($_FILES['upload'])) {
        exit("업로드 파일 존재하지 않음");
    }//if
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
        } // switch
    }//if

//3. 업로드 제한용량 체크(서버측에서 5M로 제한)
    if($_FILES['upload']['size'] > 5242880) {
        exit("업로드 최대용량 초과");
    }//if

//4. 업로드 허용 확장자 체크(보편적인 jpg,jpeg,gif,png,bmp 확장자만 필터링)
    $ableExt = array('jpg','jpeg','gif','png','bmp');
    $path = pathinfo($_FILES['upload']['name']);
    $ext = strtolower($path['extension']);

    if(!in_array($ext, $ableExt)) {
        exit("허용되지 않는 확장자입니다.");
    }//if

//5. MIME를 통해 이미지파일만 허용(2차 확인)
    $ableImage = array('image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/gif','image/bmp','image/pjpeg');
    if(!in_array($_FILES['upload']['type'], $ableImage)) {
        exit("지정된 이미지만 허용됩니다.");
    }//if

//6. DB에 저장할 이미지 정보 가져오기(width,height 값 활용)
    $img_size = getimagesize($_FILES['upload']['tmp_name']);

    //DB연결
    $db = @new mysqli('localhost','capstone','zoqtmxhs','capstone');
    if(mysqli_connect_errno()) {
        exit("DB연결오류");
    }//if

    //do~while: 새로만든 파일명이 중복일경우 반복하기 위한 루틴
    do{

//6. 새로운 파일명 생성(마이크로타임과 확장자 이용)
        $time = explode(' ',microtime());
        $file_name = $time[1].substr($time[0],2,6).'_'.strtoupper($ext);

        //중요 이미지의 경우 웹루트(www) 밖에 위치할 것을 권장(예제 편의상 아래와 같이 설정)
        $file_path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';

//7. 생성한 파일명이 DB내에 존재하는지 체크
        $query = sprintf("SELECT * FROM file_list WHERE db_filename = '%s'",$file_name);
        $result = $db->query($query);

        //생성한 파일명이 중복하는 경우 새로 생성해서 체크를 반복(동시저장수가 대량이 아닌경우 중복가능 희박)
    }while($result->num_rows > 0);

    //db에 저장할 정보 가져옴
    $upload_filename = $db->real_escape_string($_FILES['upload']['name']);
    $file_size = $_FILES['upload']['size'];
    $file_type = $_FILES['upload']['type'];
    $upload_date = date("Y-m-d H:i:s");

    //오토커밋 해제
    $db->autocommit(false);
    $workshop_no = 1;
    $write_no=1;
//8. db에 업로드 파일 및 새로 생성된 파일정보등을 저장
    $query = sprintf("INSERT INTO file_list
		(workshop_no,write_no,file_path,upload_date,file_type,file_size,upload_filename,db_filename) 
		VALUES ('{$workshop_no}','{$write_no}','{$file_path}','{$upload_date}','{$file_type}','{$file_size}','{$upload_filename}','{$db_filename}')");
    $db->query($query);

    //DB에 파일내용 저장 성공시
    if($db->affected_rows > 0) {

//9. 업로드 파일을 새로 만든 파일명으로 변경 및 이동
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $file_path.$file_naame)) {

//10. 성공시 db저장 내용을 적용(커밋)
            $db->commit();
            echo "업로드 성공";
            ?>
            <script type="text/javascript">
                // 첫번째 파라미터로 실행될 함수, 두번째 파라미터 지연시간 1/1000 초
                setTimeout(function(){location.href="http://hae.so/capstone/index.php";},1000); //2초후 이동
            </script>
<?
        }else{
            //실패시 db에 저장했던 내용 취소를 위한 롤백
            $db->rollback();
            exit("업로드 실패");
        }//if
    }//if
}//if
#글 삽입
?>

