<?
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
				mysqli_query($connect, "set names utf8");
				?>
        <!DOCTYPE html>
        <html lang="ko">
        <head>
          <title>디지털 공방에 오신 것을 환영합니다.</title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
          <link rel="stylesheet" href="css/index.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
          <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
          <script src="js/capstone.js"></script>
        </head>

        <body style='background-color:#f9f9f9;'>
        <?include_once("nav.php")?>



<style>
#submitYesBtn
{
	background-color:#f9f9f9;
	color: #000000;
	border:none;
}
#submitNoBtn
{
	background-color:#f9f9f9;
	color: #000000;
	border:none;
}

</style>
<script src="js/capstone.js"></script>
</head>

<body>
 <div class="container-fluid">
	<div class="row content" >
		<div class="col-sm-12">
			<br><br>
			<form method="post" onsubmit="return workshopSearch();">
			<div class="input-group" style="width:450px; margin:0 auto;">

					<input type="text" name="keyword" id="searchKeyword" style='border:none;' class="form-control" placeholder="공방이름으로 검색(2글자 이상)">
					<span class="input-group-btn">
					<button class="btn btn-default" type="submit">
						<span class="glyphicon glyphicon-search"></span>
					</button>
					</span>
			</div>
			</form>
		</div>
		<br>
		<div class="row" style='max-width:900px; margin:0 auto; background-color:#f9f9f9;'>
			<div class="col-sm-12" id="searchArea">
			</div>
		</div>
		<div class="row" id="mainArea" style='max-width:900px; margin:0 auto; background-color:#f9f9f9;'>

			<div class="col-sm-<?if(!$_SESSION[id]) echo "12"; else echo "8";?>">
				<h2>공방리스트</h2>
				<?
					$query = mysqli_query($connect, "select no,name,master from dg_workshop order by no desc limit 0,15");
					while($ret = mysqli_fetch_array($query,MYSQLI_BOTH))
					{
					?>
						<div style="width:100%; border-radius:5px; padding:0 0 0 3px; display: flex; align-items: center; height:90px; background-color:white; border:1px solid #e9e9e9;">
							<div class="row" style="width:100%;">
								<div class="col-sm-2" style="margin:0 0 5px 10px;">
									<img src='img/profile/default.png' style="width:50px; height:auto;" />
								</div>
								<div class="col-sm-8">
									<a href="http://capstone.hae.so:9000/index.php?no=<?=$ret[no]?>"><span style="font-size:16px; color:black;"><?=$ret[name]?></span></a>
									<?$arr2 = mysqli_fetch_array(mysqli_query($connect, "select nickname from dg_member where email='{$ret[master]}'"),MYSQLI_BOTH);?>
									<span style="font-size:12px; color:#999999;"><?=$arr2[nickname]?>님의 공방</span><br>
									<?$arr3 = mysqli_fetch_array(mysqli_query($connect, "select count(*) from dg_workshop_member where workshop_no={$ret[no]}"),MYSQLI_BOTH);?>
									<div class="row" style="width:100%;">
										<div class="col-sm-2" style="text-align:center;">
											<span style="font-size:18px;"><?=$arr3[0];?></span><br>
											<span style="font-size:11px;">멤버</span>
										</div>
										<?$arr4 = mysqli_fetch_array(mysqli_query($connect, "select count(*) from dg_write where workshop_no={$ret[no]}"),MYSQLI_BOTH);?>
										<div class="col-sm-2" style="text-align:center;">
											<span style="font-size:18px;"><?=$arr4[0];?></span><br>
											<span style="font-size:11px;">글</span>
										</div>
										<?$arr5 = mysqli_fetch_array(mysqli_query($connect, "select count(*) from dg_file_list where workshop_no={$ret[no]}"),MYSQLI_BOTH);?>
										<div class="col-sm-2" style="text-align:center;">
											<span style="font-size:18px;"><?=$arr5[0];?></span><br>
											<span style="font-size:11px;">파일</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?
					echo "<br>";
					}
				?>
			</div>

			<div class="col-sm-4" style='border:1px solid #e9e9e9; border-radius:6px; background-color:white;'>
				<div class="row">
					<div class="col-sm-12">
						<?
						if($_SESSION[id])
						{
						?>
						<center>
							<?
							if(!file_exists("img/profile/".$_SESSION[no].".png"))
							{
								echo "<br><img src='img/profile/default.png' id='myImage' style='width:64px; height:64px; border-radius:64px;'/>";
							}
							else
							{
								echo "<br><img src='img/profile/".$_SESSION[no].".png' />";
							}
							?>
							<br>
							<h4><?=$_SESSION[nick]?></h4>
							<br>
							나의 공방<br>
							<?
							$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
							mysqli_query($connect, "set names utf8");
							#자기가 참여하고 있는 공방 목록 전부 보여준다.
							$query = mysqli_query($connect, "select * from dg_workshop_member where member_no='{$_SESSION[no]}'");
							while($ret = mysqli_fetch_array($query,MYSQLI_BOTH))
							{
								$query1 = mysqli_query($connect, "select * from dg_workshop where no='{$ret[workshop_no]}'");
								while($ret1=mysqli_fetch_array($query1,MYSQLI_BOTH)) {
									echo "<a href='http://capstone.hae.so:9000/index.php?no={$ret1[no]}' target='_self'>{$ret1[name]}</a><br>";
								}
							}


							?>
							<br>
							<button type="button" class="btn btn-default" onclick="location.href='create.php'">공방 만들기</button></center><br>
					</div>
				</div>
				<?
						#초대한 사람의 이름과 공방번호를 보여준다.
						#echo $_SESSION[no];
						$query = mysqli_query($connect, "select distinct * from dg_member_invite where member_no={$_SESSION[no]} and accepted = 0");
						while($ret = mysqli_fetch_array($query,MYSQLI_BOTH))
						{
							$invite = mysqli_fetch_array(mysqli_query($connect, "select name,master from dg_workshop where no='{$ret[workshop_no]}'"),MYSQLI_BOTH);

							//$ret[workshop_no] : 공방번호
							//$ret[member_no] : 회원번호
					?>
				<div class="row" style="margin: 10px 0 10px 0;">
					<div class="col-sm-12">

					<!--자신이 받은 초대장이 보여진다.-->
					<center>
						<?
							$nick = mysqli_fetch_array(mysqli_query($connect, "select nickname from dg_member where email='{$invite[master]}'"),MYSQLI_BOTH);
							echo "<br>".$nick[nickname]."님이 <b>".$invite[name]."</b> 공방에서 같이 작업하기를 원합니다.";
						?>
						<br><br>
						<button type="button" class="btn btn-primary btn-lg" onclick="invite(this,<?=$ret[workshop_no]?>,<?=$ret[member_no]?>,true);" name="yesBtn" id="submitYesBtn">V 수락</button>
						<button type="button" class="btn btn-primary btn-lg" onclick="invite(this,<?=$ret[workshop_no]?>,<?=$ret[member_no]?>,false);" name="noBtn" id="submitNoBtn">X 거절</button>


					</div>
				</div>
				<?}}?>
			</div>





		</div>
	</div>
</div>
</body>
</html>
