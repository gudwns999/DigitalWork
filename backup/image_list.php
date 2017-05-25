<div class='container' style='width:100%;'>
<?

#DB연결------------------------------------------------
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");
if(!$connect) {
    exit("DB연결오류");
}
#-----------------------------------------------------

$workshop_no=$_GET[no];

//과정 DB화
$query = mysqli_query($connect,"SELECT *  FROM dg_workshop_process WHERE workshop_no='$workshop_no'");
$processList = array("");
while($arr = mysqli_fetch_array($query,MYSQLI_BOTH))
{
	array_push($processList,$arr[name]);
}

$query = mysqli_query($connect,"SELECT *  FROM dg_write WHERE workshop_no='$workshop_no' order by write_no desc");


while($arr = mysqli_fetch_array($query,MYSQLI_BOTH))
{
	$version = mysqli_fetch_array(mysqli_query($connect,"select * from dg_file_list where parent_no = {$arr[write_no]} order by file_ver desc limit 0,1"),MYSQLI_BOTH);
	$member = mysqli_fetch_array(mysqli_query($connect,"select nickname from dg_member where no = {$arr[member_no]}"),MYSQLI_BOTH);
	$fno = $version[file_no];
?>
	<div class="workshopList row <?=$processList[intval($arr[process_no])]?> <?=$member[nickname]?>" style="width:100%;" >
		<div class="col-sm-3" style="height:150px;" onclick='window.open("board.php?no=<?=$arr[write_no]?>","_self");'>
			<?if(preg_match("/stl/si",$version[file_type])){?>
			<iframe src="image_view.php?no=<?=$version[file_no]?>" style=" height:100%; overflow:hidden; border:none; max-width:100%;height:auto;"/></iframe>
			<?}else{?>
			<img src="image_view.php?no=<?=$version[file_no]?>" style="max-width:100%;height:auto;"/>
			<?}?>
		</div>
		<div class="col-sm-9" style="height:150px;" >
			<a style="font-size:20px; color:black;" href="board.php?no=<?=$arr[write_no]?>"><?=$version[title]?></a>
			<span style="color:#aaaaaa; font-size:12px;"><?=$processList[intval($arr[process_no])]?></span>
			&nbsp;
			
			<span style="color:#666666; font-size:13px;"><? printf("v%.1f",intval($version[file_ver]) / 10);?></span>
			<br>
			<span style="color:#666666; font-size:13px;"><?=$member[nickname]?></span>
			<br><br>
			<?=$arr[write_description]?><br><br>
			<button type="button" class="btn btn-default" onclick='window.open("image_view.php?no=<?=$fno?>&d=1");'>
			<span class="glyphicon glyphicon-download"></span> 다운로드
			</button>
			
		</div>
	</div>
	<br>
<?}?>

</div>