<?
if(!$_GET || !is_numeric($_GET[no])) die("<script>history.back();</script>");
$no = $_GET[no];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <style>
        #file_list table{border:1px solid gray;border-collapse:collapse;};
        #file_list th, #file_list td{border:1px solid gray;padding:5px;}
    </style>

  <title>디지털공방</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Explorer에서도 Bootstrap을 쓰게 해주려면 아래를 추가 -->
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
<body style="background-color:#f9f9f9;">
<?include_once("nav.php")?>
<br>
<div class="container" style="max-width:1000px; background-color:white; border-radius:5px; border:1px solid #e9e9e9;">
	<div class="page-header">
		<!--DB연결-->
		<h1><?
		$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
		mysqli_query($connect, "set names utf8");
		$query = mysqli_query($connect, "select * from dg_workshop where no='{$_GET[no]}'");
		$arr = mysqli_fetch_array($query);
		echo $arr[name];
		?>
		<button type="button" style="margin:0 15px 0 0;" class="btn btn-default pull-right" onclick='window.open("create.php?mod=1&no=<?=$_GET[no]?>","_self");'>
			<span class="glyphicon glyphicon-cog"></span> 설정 변경
		</button>
		<button type="button" style="margin:0 15px 0 0;" class="btn btn-default pull-right" onclick='window.open("upload.php?no=<?=$_GET[no]?>","_self");'>
			<span class="glyphicon glyphicon-upload"></span> 업로드
		</button>
		</h1>
		
		<p><?=$arr[description]?></p>
		<br>
			
	</div>
<br>
	<!--그리드로 보여줄것-->
	<?//include_once("image_grid.php")?>
	<div style='width:100%; margin:0 auto;'>
		<div class="row" style="width:100%;">
			<div class="col-sm-3" style="height:700px; border-right:1px solid #d9d9d9;">
				<?include_once("make_left_menu.php")?>
			</div>
			<div class="col-sm-9" style="height:700px; overflow-y:auto;">
			<span style='color:#898989; font-size:11px;'>※좌측의 썸네일 또는 제목을 클릭하면 상세보기가 가능합니다.</span><br>
				<?include_once("image_list.php")?>
			</div>
		</div>
	</div>
	<br>
</div>
<br><br><br>
</body>
</html>
