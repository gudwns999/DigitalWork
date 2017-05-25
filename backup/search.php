<?
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

if(mb_strlen($_POST[keyword])==0)
	die("1");
else if(mb_strlen($_POST[keyword]==1))
	die("2");
else
{
	$keyword = mysqli_real_escape_string($connect,$_POST[keyword]);
	$sql = "select * from dg_workshop where name like '%{$keyword}%' order by no desc";
	$ret = mysqli_query($connect, $sql);
	$cnt = mysqli_num_rows($ret);
	if(!$cnt) die("3");
	echo "총 ".$cnt." 개의 결과를 찾았습니다. <span style='cursor:pointer; color:blue; text-decoration:underline;' onclick='$(\"#mainArea\").show();$(\"#searchArea\").html(\"\");'>돌아가기</span><br><br>";
	while($arr = mysqli_fetch_array($ret, MYSQLI_BOTH))
	{
		?>
			<div style="width:100%; border-radius:5px; padding:0 0 0 3px; display: flex; align-items: center; height:90px; background-color:white;">
				<div class="row" style="width:100%;">
					<div class="col-sm-2" style="margin:0 0 5px 10px;">
						<img src='img/profile/default.png' style="width:50px; height:auto;" />
					</div>
					<div class="col-sm-8">
						<a href="make.php?no=<?=$arr[no]?>"><span style="font-size:16px; color:black;"><?=$arr[name]?></span></a>
						<?$arr2 = mysqli_fetch_array(mysqli_query($connect, "select nickname from dg_member where email='{$arr[master]}'"),MYSQLI_BOTH);?>
						<span style="font-size:12px; color:#999999;"><?=$arr2[nickname]?>님의 공방</span><br>
						<?$arr3 = mysqli_fetch_array(mysqli_query($connect, "select count(*) from dg_workshop_member where workshop_no={$arr[no]}"),MYSQLI_BOTH);?>
						<div class="row" style="width:100%;">
							<div class="col-sm-2" style="text-align:center;">
								<span style="font-size:18px;"><?=$arr3[0];?></span><br>
								<span style="font-size:11px;">멤버</span>
							</div>
							<?$arr4 = mysqli_fetch_array(mysqli_query($connect, "select count(*) from dg_write where workshop_no={$arr[no]}"),MYSQLI_BOTH);?>
							<div class="col-sm-2" style="text-align:center;">
								<span style="font-size:18px;"><?=$arr4[0];?></span><br>
								<span style="font-size:11px;">글</span>
							</div>
							<?$arr5 = mysqli_fetch_array(mysqli_query($connect, "select count(*) from dg_file_list where workshop_no={$arr[no]}"),MYSQLI_BOTH);?>
							<div class="col-sm-2" style="text-align:center;">
								<span style="font-size:18px;"><?=$arr5[0];?></span><br>
								<span style="font-size:11px;">파일</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
		<?
	}
}
?>
