<?
session_start();

//DB연결
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");
if(!$connect) {
    exit("DB연결오류");
}
echo "<br><br>
<div class='row' style='width:100%;'>
	<div class='col-sm-6'  style='text-align:center;'>
		닉네임
	</div>
	<div class='col-sm-6'  style='text-align:center;'>
		글 보이기
	</div>
</div><br>";
$query = mysqli_query($connect, "select * from dg_workshop_member where workshop_no='{$_GET[no]}'");
while($arr = mysqli_fetch_array($query))
{
	$member = mysqli_fetch_array(mysqli_query($connect, "select nickname from dg_member where no={$arr[member_no]}"),MYSQLI_BOTH);
?>
	<div class='row' style='width:100%;'>
		<div class='col-sm-6'  style='text-align:center; font-size:16px;'>
			<?=$member[nickname]?>
		</div>
		<div class='col-sm-6' style='text-align:center;'>
			<input type='checkbox' style='width:16px; height:16px;'class='hideBox' checked value='<?=$member[nickname]?>'>
		</div>
	</div>
<?
}

echo "<br><br>
<div class='row' style='width:100%;'>
	<div class='col-sm-6'  style='text-align:center;'>
		단계
	</div>
	<div class='col-sm-6'  style='text-align:center;'>
		글 보이기
	</div>
</div><br>";
$query = mysqli_query($connect, "select * from dg_workshop_process where workshop_no='{$_GET[no]}'");
while($arr = mysqli_fetch_array($query))
{
?>
	<div class='row' style='width:100%;'>
		<div class='col-sm-6'  style='text-align:center; font-size:16px;'>
			<?=$arr[name]?>
		</div>
		<div class='col-sm-6' style='text-align:center;'>
			<input type='checkbox' style='width:16px; height:16px;'class='hideBox' checked value='<?=$arr[name]?>'>
		</div>
	</div>
<?
}
mysql_close();
?>