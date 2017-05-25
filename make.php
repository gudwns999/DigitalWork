<?
session_start();
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

if($_GET[no]) $no = intval($_GET[no]);


if($_GET[u])
{
	$query = mysqli_query($connect, "SELECT * FROM dg_write WHERE write_no = {$no}");
    $workshop = mysqli_fetch_array($query,MYSQLI_BOTH);

	$arr = mysqli_fetch_array(mysqli_query($connect, "select * from dg_file_list where parent_no={$no} order by file_ver desc limit 0,1"),MYSQLI_BOTH);
	$latestVersionNo = $arr[file_no];	//parent가 n인 글의 최신 버전 파일 번호
	//die(print_r($arr));
}
?>

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
<script>
	$.fn.setPreview = function(opt){
		"use strict"
		var defaultOpt = {
			inputFile: $(this),
			img: null,
			w: 200,
			h: 200
		};
		$.extend(defaultOpt, opt);

		var previewImage = function(){
			if (!defaultOpt.inputFile || !defaultOpt.img) return;

			var inputFile = defaultOpt.inputFile.get(0);
			var img       = defaultOpt.img.get(0);

			// FileReader
			if (window.FileReader) {
				// image 파일만
				if (!inputFile.files[0].type.match(/image\//)) return;

				// preview
				try {
					var reader = new FileReader();
					reader.onload = function(e){
						img.src = e.target.result;
						img.style.width  = defaultOpt.w+'px';
						img.style.height = defaultOpt.h+'px';
						img.style.display = '';
					}
					reader.readAsDataURL(inputFile.files[0]);
				} catch (e) {
					// exception...
				}
				// img.filters (MSIE)
			} else if (img.filters) {
				inputFile.select();
				inputFile.blur();
				var imgSrc = document.selection.createRange().text;

				img.style.width  = defaultOpt.w+'px';
				img.style.height = defaultOpt.h+'px';
				img.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enable='true',sizingMethod='scale',src=\""+imgSrc+"\")";
				img.style.display = '';
				// no support
			} else {      }
		};
		// onchange
		$(this).change(function(){
			previewImage();
		});
	};
	$(document).ready(function(){
		var opt = {
			img: $('#img_preview'),
			w: 200,
			h: 200
		};
		$('#upload').setPreview(opt);
	});
</script>
<!--body-->
<div class="modal-body">
<button type="button" style = "vertical-align:middle;" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon glyphicon-remove"></span></button> <br>
		
	<form action="upload_check.php" method=post class="form-inline" role="form" align="strong" enctype="multipart/form-data">
		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				작성자
			</div>
			<div class="col-sm-10">
				<?= $_SESSION["nick"] ?>
			</div>
		</div>
		<br>

		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				작업 단계
			</div>

			<div class="col-sm-10">
			<?if(!$_GET[u])
			{?>
					<select name="process_no">
						<!--DB-->
						<?
						$i=1;
						$workshop_no =$_GET[no];
						$query = mysqli_query($connect, "select * from dg_workshop_process where workshop_no='{$_GET[no]}'");
						while($ret = mysqli_fetch_array($query,MYSQLI_BOTH))
						{
              #$process_no = $ret[process_no];
							?><option value="<?=$i?>"><? echo "".$ret[name];?></option><?
							$i++;
						}?>
					</select>
				<?}
				else
				{
					$query = mysqli_query($connect,"SELECT name FROM dg_workshop_process WHERE workshop_no={$arr[workshop_no]} order by process_no asc");
					$processList = array("0");
					while($arr3 = mysqli_fetch_array($query,MYSQLI_BOTH))
					{
						array_push($processList,$arr3[name]);
					}
					$workshop_no = $workshop[workshop_no];
					echo $processList[intval($workshop[process_no])];
				}?>
			</div>
		</div>
		<br>
		<?if($_GET[u]){?>
		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				현재 버전
			</div>
			<div class="col-sm-10">
				<? printf("%.1f",intval($arr[file_ver]) / 10);?>
			</div>
		</div>
		<br>
		<?}?>
		<?if($_GET[u]){?>
		<div class="row" style="width:100%;">
			<div class="col-sm-2" style="height:250px;">
				기존 파일
			</div>
			<div class="col-sm-10" style="height:250px;">
			<?if(preg_match("/stl/si",$arr[file_type])){?>
			<iframe src="image_view.php?no=<?=$latestVersionNo?>" style=" overflow:hidden; border:none; max-width:100%;height:auto;"/></iframe>
			<?}else{?>
			<img src="image_view.php?no=<?=$latestVersionNo?>" style="width:auto;max-height:250px;" />
			<?}?>
			</div>
		</div>
		<br>
		<?}?>
		
		<div class="row" style="width:100%;">
			<div class="col-sm-2" style="height:250px;">
				<?if($_GET[u]) echo"새로운 ";?>파일
			</div>
			<div class="col-sm-10"  style="height:250px;">
				<fieldset>
					<input type="hidden" name ="workshop_no" value="<?=$workshop_no?>"/>
					<input type="hidden" name = "target" value="<?=$_GET[no]?>"/>
					<input type="hidden" name="update" value="<?if(!$_GET[u]) echo "0"; else echo "1";?>" />
					<input type="file" id="upload" name="upload"/>
				</fieldset>
				<br>
				<img id="img_preview" style="display:none;"/><!--미리보기 이미지가 나오는 부분-->
			</div>
		</div>
		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				제목
			</div>
			<div class="col-sm-10">
				<input class="form-control" name="write_name" type="text" style="width:75%;" placeholder="작업한 파일의 제목을 입력하세요.">
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				설명
			</div>
			<div class="col-sm-10">
			    <textarea class="form-control" name="write_description" style="width:75%;" rows="7" placeholder="작업 내용을 입력하세요."></textarea>
			</div>
		</div>
		<br>

		<center>
			<input type="submit" class="btn btn-default" value="업로드">
			&nbsp;&nbsp;
		</center>
		<br>
		<br>
		<br>
	</form>
</div>


</body>
</html>

<?
function alert($s)
{
	die("<script>alert('{$s}'); history.back();</script>");
}

?>