<?
session_start();
$connect = mysqli_connect("localhost","capstone","zoqtmxhs","capstone");
mysqli_query($connect, "set names utf8");

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
?>
<!DOCTYPE html>
<head>
<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="http://capstone.hae.so/v2/css/index.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://capstone.hae.so/v2/js/client.php?no=<?=$_GET[no]?>"></script>
	<script src="http://capstone.hae.so/v2/js/capstone.js"></script>
	<script src="http://capstone.hae.so/v2/js/imagePreview.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?include_once("nav.php");?>

<div style="height:95%; white-space:nowrap;">
	<div class="container" id="infinite" style="overflow-x: scroll; height:100%; width:100%">
		<br>
		<button class="button button2" id="makeCardBtn" onclick="confirmCreateCard()"> 단계추가 </button>

		<div style="float: right;" class="fixed">
		<?include_once("sidebar.php");?>
		</div>
	</div>
</div>

<div class="modal" id = "fileUpload" >
   <div class="modal-dialog">
    <div class="modal-content" style="padding: 10px 10px 10px 10px;">
        <!-- remote ajax call이 되는영역 -->
		<button type="button" style = "vertical-align:middle;" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon glyphicon-remove"></span></button> <br>
		
	<form method="post" action="http://capstone.hae.so/v2/upload_check.php" id="fileUploadForm" class="form-inline" enctype="multipart/form-data">
		<input type="hidden" id="currentpno" value="0" />
		<input type='hidden' id='umode' name="update"/>
		<center><h3 id="currentpname"></h3></center>
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
			<div class="col-sm-2">
				<?if($_GET[u]) echo"새로운 ";?>파일
			</div>
			<div class="col-sm-10">
				<fieldset>
					<input type="hidden" name ="workshop_no" value="<?=$_GET[no]?>"/>
					<input type="hidden" id="uploadPno" name ="process_no" value=""/>
					<input type="hidden" name = "target" value="<?=$_GET[no]?>"/>
					<input type="hidden" name="update" value="<?if(!$_GET[u]) echo "0"; else echo "1";?>" />
					<input type="file" id="upload" id="fileContent" name="fupload" enctype="multipart/form-data"/>
				</fieldset>
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				미리보기
			</div>
			<div class="col-sm-10">
				<img id="img_preview" style="display:none;"/><!--미리보기 이미지가 나오는 부분-->
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				제목
			</div>
			<div class="col-sm-10">
				<input class="form-control" name="write_name" id="fileTitle" type="text" style="width:100%;" placeholder="작업한 파일의 제목을 입력하세요.">
			</div>
		</div>
		<br>
		<div class="row" style="width:100%;">
			<div class="col-sm-2">
				설명
			</div>
			<div class="col-sm-10">
			    <textarea class="form-control" name="write_description" id="fileDecsription" style="width:100%;" rows="7" placeholder="작업 내용을 입력하세요."></textarea>
			</div>
		</div>
		<br>

		<center>
			<input type="submit" id="submitBtn" class="btn btn-default" style="width:150px;text-align:center;" value="업로드">
			&nbsp;&nbsp;
		</center>
		<br>
	</form>
    </div>
  </div>
</div>

<div class="modal" id="detailThread">
	<div class="modal-dialog">
		<div class="modal-content" style="width:750px; padding: 12px 12px 12px 12px;">
			<div id="commentFno" style="display:none;"></div>
			<!--x 버튼-->
			<div class="form-group">
				<button type="button" style = "vertical-align:middle;" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon glyphicon-remove"></span></button>
			</div>
			<!--File title-->
			<div class="form-group">
				<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;
				<input type="text" class="form-control, bg" id ="modalFileName" value="파일 제목" style="border: 0px; font-size:15pt; font-weight:bold;"><br>
				<div style="margin:0 0 0 30px;">단계 : <u id="modalProcessName">단계 이름</u></div>
				<br>
				<div id="coMem" style="margin:0 0 0 30px;">제작자 : <span id="coMemList"></span> <span class ="glyphicon glyphicon-plus"></span><a href="#" id ="memBtn" style ="text-align:center">멤버</a></div>
			</div>
			<br>

			<!--description--> 	 
			<div class="form-group">
				<p><button type="button" id = "descripstion" class="btn">&nbsp;&nbsp;&nbsp;
				<span class="glyphicon glyphicon-align-left" style = "color:gray"></span>&nbsp;<u><font color="gray" >추가 설명</font></u></button></p>
				<div id = "addText">
					<textarea id="addtt"class="form-control" placeholder="설명을 입력해주세요" style = "width:80%"></textarea>
					<button type="submit" id="submitBtn" class ="btn btn-default" style="width:50px; float:left; font-size:13px;">저장</button> &nbsp;
					<button type="button" id= "cancel" style = " vertical-align:middle; float:left; margin-top:11px; padding-left:12px" class="close" aria-hidden="true">✖</button>
				</div>
			</div><br>

			<div class="row">
				<div class = "col-lg-10">
					<!--comment--> 	 
					<div class="form-group">
						<label for="comment"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;댓글</label>
						<form onsubmit="return uploadComment();">
							<textarea  id="cardComment" name="description" class="form-control" placeholder="댓글을 입력해주세요"></textarea>
							<br><button type="submit" class="btn btn-default"  style="width:50px; font-size:13px;">작성</button>
						</form>
						<div style="width:100%;">별점
							<span class="star-input" style="text-align:left;" id="star-inputs"><span class="input">
								<input type="radio" name="star-input" id="p1" value="1" onclick="rating(1)"><label for="p1">1</label>
								<input type="radio" name="star-input" id="p2" value="2" onclick="rating(2)"><label for="p2">2</label>
								<input type="radio" name="star-input" id="p3" value="3" onclick="rating(3)"><label for="p3">3</label>
								<input type="radio" name="star-input" id="p4" value="4" onclick="rating(4)"><label for="p4">4</label>
								<input type="radio" name="star-input" id="p5" value="5" onclick="rating(5)"><label for="p5">5</label>
								<input type="radio" name="star-input" id="p6" value="6" onclick="rating(6)"><label for="p6">6</label>
								<input type="radio" name="star-input" id="p7" value="7" onclick="rating(7)"><label for="p7">7</label>
								<input type="radio" name="star-input" id="p8" value="8" onclick="rating(8)"><label for="p8">8</label>
								<input type="radio" name="star-input" id="p9" value="9" onclick="rating(9)"><label for="p9">9</label>
								<input type="radio" name="star-input" id="p10" value="10" onclick="rating(10)"><label for="p10">10</label>
							</span>
						</div>
					</div>
					<div class="form-group" id="cardCommentList"></div>
					
					<!--body_history-->
					<div class="form-group">
						<label for="history"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;히스토리</label>
					</div>
				</div>

				<!--functions-->	
				<div class="col-lg-2">
					<h4><b>기능</b></h4>
					<div class="form-group">
						<button onclick="location.href='invite.php'" id="share" type="button" class="btn btn-default" data-dismiss="modal" style="width:100%; text-align:center;">수정내역</button>
					</div>
					<div class="form-group">
						<button onclick="location.href='invite.php'" id="share" type="button" class="btn btn-default" data-dismiss="modal" style="width:100%; text-align:center;">공유</button>
					</div>
					<div class="form-group">
						<button type="button" id="voteBtn" class="btn btn-default" style="width:100%; text-align:center;" onclick="vote()"><span id="voteCheck"></span><span id="voteCnt"></span></button>
					</div>
					<div class="form-group">
						<button onclick="location.href='invite.php'" type="button" class="btn btn-default" data-dismiss="modal" style="width:100%; text-align:center;">삭제</button>
					</div> 
				</div>
			</div></div>
	</div>
</div>

<div id="dialogMem" style="z-index:2000;">	
	<span style="font-size:13px;">추가할 공방 멤버를 선택해 주세요.<br><br></span>
</div>
</body>
</html>
<div id="ajaxOutput" style="display:none;"></div>  
