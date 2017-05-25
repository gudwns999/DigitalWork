<?
session_start();
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
if(!$connect)
	exit("DB연결오류");
mysqli_query($connect, "set names utf8");
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
<div class="container" style="border:1px solid #e9e9e9;max-width:900px;background-color:white;border-radius:6px;margin:0 auto;">
<cetner>

	<div style="font-size:24px;">수정내역</div>
	<br>

	<? 
	$mNo =  mysqli_fetch_array(mysqli_query($connect, "select member_no from dg_write where write_no={$_GET[no]}"),MYSQLI_BOTH);
	$member = mysqli_fetch_array(mysqli_query($connect, "select nickname from dg_member where no={$mNo[member_no]}"),MYSQLI_BOTH);
	$tmp = mysqli_query($connect, "select * from dg_file_list where parent_no = {$_GET[no]} order by file_ver desc");
	$i = 0;
	while($trace = mysqli_fetch_array($tmp,MYSQLI_BOTH))
	{
		?>
		<div class="row" style="width:100%;">
			<div class="col-sm-5" style="border-right:1px solid #e9e9e9; display:flex; align-items:center; height:300px;">
			<?
				if($trace[file_ver] == "10")
				{
					echo "<span class='well'><b>".$trace[upload_date]."</b><br>";
					echo $member[nickname]."님이 최초로 글을 작성하였습니다.<br><br>이름 : ".$trace[title]."<br>설명 : ".$trace[description];
				}
				else
				{
					$ver = intval($trace[file_ver]);
					printf("<span class='well'><b>%s</b><br>%s 님이 글의 버전을 업데이트 하였습니다. (%.1f -> <b>%.1f</b>)<br><br>새로운 이름 : %s<br>새로운 설명 : 
				%s",$trace[upload_date],$member[nickname],($ver-1)/10,$ver/10,$trace[title],$trace[description]);
				}
			?>
			<br><br>
			<button type="button" class="btn btn-default" onclick='window.open("image_view.php?no=<?=$trace[file_no]?>&d=1");'>
			<span class="glyphicon glyphicon-download"></span> 다운로드
			</button>
			</span>
			</div>
			<div class="col-sm-7" style="text-align:center; height:300px;">
				<?if(preg_match("/stl/si",$trace[file_type])){?>
				<iframe src="image_view.php?no=<?=$trace[file_no]?>" style=" overflow:hidden; border:none; width:auto;height:250px;"/></iframe>
				<?}else{?>
				<img src="image_view.php?no=<?=$trace[file_no]?>" style="width:auto;max-height:250px;" />
				<?}?>
			</div>
		</div>
	<?
	}

	?>
	<br>
</center>
</div>
</body>
</html>