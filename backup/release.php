<!DOCTYPE html>
<html lang="ko">

<!-- DB 연결하고 시작 -->
<?
	$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
	mysqli_query($connect, "set names utf8");
	if(!$_GET || !is_numeric($_GET[no]))
		die("<script>history.back();</script>");
	$no = $_GET[no];
?>

<head>
	<title>디지털공방</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<!-- default 버튼 색 지정-->
	<style>
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

<body>
<?include_once("nav.php")?>

<div class="container" style="max-width:900px;">
	<br><br><br>
	<ul class="nav nav-pills">
		<li><a href="http://hae.so/capstone/create.php">생성</a></li>
		<li><? echo '<a href="http://hae.so/capstone/make.php?no='.$no.'">제작</a>' ?></li>
		<li class="active"><a href="#">배포</a></li>
	</ul>

	<div class="page-header">
		<h1>
			<?
			$retrieveWork = mysqli_query($connect, "select * from dg_workshop where no='{$_GET[no]}'");
			$works = mysqli_fetch_array($retrieveWork);
			echo $works[name];
			?>
		</h1>
	</div>

	<p>다른 사람에게 배포할 작업을 선택하세요.</p>
	<p>공방을 대표하는 썸네일을 선택하세요.</p><br><br><br><br>

	<!-- 공방 DB에서 작업들을 가져옴 -->
	<?
	$workShopSelect = mysqli_query($connect, "select * from dg_file_list where workshop_no = '{$_GET[no]}'");
	$workShopMemSelect = mysqli_query($connect, "select * from dg_write where workshop_no = '{$_GET[no]}'");

	?>
	<form method="post">

		<table class="table">
			<thead>
			<tr>
				<th><center>배포 선택</center></th>
				<th><center>썸네일 선택</center></th>
				<th><center>이미지</center></th>
				<th><center>작업 이름</center></th>
				<th><center>작업 내용</center></th>
			</tr>
			</thead>
			<tbody>
			<?
			while($row = mysqli_fetch_array($workShopSelect,MYSQLI_BOTH))
			{
				$row2 = mysqli_fetch_array($workShopMemSelect,MYSQLI_BOTH)
				?>
				<tr>
					<td><center><input type="checkbox"></center></td>
					<td><center><input type="radio" name="optradio"></center></td>
					<td><center> <!-- 이미지 썸네일 선택 -->
							<?
							$image = $row['db_filename'];
							$path = 'http://hae.so/capstone/KHJ/'.$image;
							echo "<img src='".$path."' alt='이미지를 불러올 수 없습니다.' style='width:128px;height:128px' />";
							?>
					</td></center>
					<!-- 작업 이름 -->
					<td><center>
							<?
							echo $row2['write_name'];
							?>
					</td></center>
					<td><center>
							<?
							echo $row2['write_description'];
							?>
					</td></center>
				</tr>
			<? } ?>
			</tbody>
		</table>
	</form>
</div>
<br><br><center><input type="submit" class="btn btn-default" value="배포" /></center><br><br>
</body>
</html>
