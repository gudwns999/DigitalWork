<?
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
        mysqli_query($connect, "set names utf8");
        if(!$connect) {
            exit("DB연결오류");
        }
if(!$_GET || !is_numeric($_GET[no])) die("<script>history.back();</script>");
$no = $_GET[no];


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8;" />
    <style>
        #file_list table{border:1px solid gray;border-collapse:collapse;};
        #file_list th, #file_list td{border:1px solid gray;padding:5px;}
    </style>
    <title>디지털공방</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/capstone.js"></script>
    <!-- default 버튼 색 지정-->
    <style>

        table, td {
            border: 1px solid black;
        }
        .btn-default {
            background: #FF4000;
            color: #fff;
        }
        .btn-default:hover {
            background: #fff;
            color: #000;
        }
        .nav-pills a {
            color:#FF4000;
        }
        .nav-pills > li.active > a {
            background-color:#FF4000;
        }
    </style>
</head>
<body  style="background-color:#f9f9f9;">
<?include_once("nav.php")?>
<br><br><br>
<div class="container" style="max-width:1000px; border-radius:5px;">
    <div class="page-header">
        <?
        $query = mysqli_query($connect, "SELECT * FROM dg_write WHERE write_no = '$no'");
        $arr = mysqli_fetch_array($query,MYSQLI_BOTH);

		//버전에 대한 언급이 없을 경우 항상 최신버전
		//있을 경우에는 ver로 체크해서 추가 체크

		if(!$_GET[ver])
		{
			$query2 = mysqli_query($connect, "SELECT * FROM dg_file_list WHERE parent_no='$no' order by file_ver desc limit 0,1");
			$arr2 = mysqli_fetch_array($query2,MYSQLI_BOTH);

		}
		else
		{
			$query2 = mysqli_query($connect, "SELECT * FROM dg_file_list WHERE parent_no='$no' and file_ver = {$_GET[ver]}");
			$arr2 = mysqli_fetch_array($query2,MYSQLI_BOTH);
			if(!count($arr2)) alert("존재하지 않거나 삭제되었습니다.");
		}
		
		$query = mysqli_query($connect, "SELECT * from dg_file_list where parent_no = {$arr[write_no]} order by file_ver desc limit 0,1");
		$cmp = mysqli_fetch_array($query,MYSQLI_BOTH);


		$latest = $cmp[file_no] == $arr2[file_no] ? true : false;

        $write_name = $arr2[title];
        $write_description = $arr2[description];
		//과정 DB화
		$query = mysqli_query($connect,"SELECT name FROM dg_workshop_process WHERE workshop_no={$arr[workshop_no]} order by process_no asc");
		$processList = array("0");
		while($arr3 = mysqli_fetch_array($query,MYSQLI_BOTH))
		{
			array_push($processList,$arr3[name]);
		}
        
        echo '<span style="font-size:36px;">'.$write_name.'</span>';
		?><button type="button" style="margin:0 15px 0 0;" class="btn btn-default pull-right" onclick='window.open("upload.php?no=<?=$arr2[workshop_no]?>","_self");'>
			<span class="glyphicon glyphicon-upload"></span> 업로드
		</button><?
		$member = mysqli_fetch_array(mysqli_query($connect,"select nickname from dg_member where no = {$arr[member_no]}"),MYSQLI_BOTH);
        ?>
    </div>
	<div class="row" style="max-height:400px; width:100%; padding:0 0 0 0;">
		<div class="col-sm-8" style="text-align:center;">
			<?if(preg_match("/stl/si",$arr2[file_type])){?>
			<iframe src="image_view.php?no=<?=$arr2[file_no]?>" style=" overflow:hidden; border:none; max-width:100%;height:250px;"/></iframe>
			<?}else{?>
			<img src="image_view.php?no=<?=$arr2[file_no]?>" style="border-top:2px solid #777777; border-bottom:2px solid #777777;width:100%;height:50%;"/>
			<?}?>
			<br><br>
		</div>
		<div class="col-sm-4">
			<button type="button" style="margin:0 15px 0 0; width:100%;" class="btn btn-default" onclick='window.open("trace.php?no=<?=$_GET[no]?>","_self");'>
			<span class="glyphicon glyphicon-th"></span> 업데이트 내역
			</button>
			<br><br>
			<ul class="list-group" style="width:100%; text-align:center;">
				<li class="list-group-item"><b><?=$member[nickname]?> | <?=$processList[intval($arr[process_no])]?> | <?printf("v %.1f",intval($arr2[file_ver]) / 10);?></b></li>
				<?if($latest){?>
				<li class="list-group-item"><span class="glyphicon glyphicon-plus-sign"></span> <a href="upload.php?u=1&no=<?=$_GET[no]?>">업데이트</a></li>
				<?}else{?>
				<li class="list-group-item" style="color:silver;"><span class="glyphicon glyphicon-plus-sign"></span>업데이트</li>
				<?}?>
				<li class="list-group-item"><span class="glyphicon glyphicon-pencil"></span> <a href="upload.php?u=1&no=<?=$_GET[no]?>">다음단계 올리기</a></li>
				<li class="list-group-item"><span class="glyphicon glyphicon-download"></span> <a href="image_view.php?no=<?=$arr2[file_no]?>&d=1">다운로드</a></li>
			</ul>
		</div>
	</div>
	<div class="row" style="width:100%;">
		<div class="col-sm-12">
			<span style="font-size:16px;">설명</span>
			<div class="well" style=" background-color:white;"><?=$write_description?></div>
		</div>
	</div>
</div>
<br>
<div id="boardArea" style="border:1px solid #e9e9e9;margin:0 auto; max-width:1000px; background-color:white; border-radius:5px;">
	<div class="row" style="width:100%;">
		<div class="col-sm-3" style="height:700px; border-right:1px solid #d9d9d9;">
			<?$_GET[no] = $arr2[workshop_no];include_once("make_left_menu.php")?>
		</div>
		<div class="col-sm-9" style="height:700px; overflow-y:auto;">
			<span style='color:#898989; font-size:11px;'>※좌측의 썸네일 또는 제목을 클릭하면 상세보기가 가능합니다.</span><br><br>
			<?include_once("image_list.php")?>
		</div>
	</div>
</div>
<br><br><br>
</body>
</html>

<?
function alert($s)
{
	die("<script>alert('{$s}'); history.back();</script>");
}

?>