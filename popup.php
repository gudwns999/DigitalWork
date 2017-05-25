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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.modal{
    background-color: transperent;  
}

#contentModal .modal-dialog  {
	width:40%;
} 
.modal-content {
	background:#f9f9f9;
}

input[type="text"]:focus{
     width: 80%; 
	 background-color:#fff;
}
.bg {
	background:#f9f9f9;
}

.btn {
	background:#f9f9f9;
	font-size=12pt; 
	width:80%;
	text-align:left;
}.btn:hover{
	background:lightgray;
	color:black;
}

.btn-default:{
    background: #f9f9f9;
	width:100%;
}
.btn-default:hover{
    background: #D84747;
	color:#fff;
}


label{
	font-size:20px; 
	width:100%;
}


.ui-dialog-titlebar{
   background:white;
   text-align:center;
   border:none;
   display: block;
}

.ui-dialog .ui-dialog-titlebar-close{
   background:white;
   text-align:center;
   border:none;
   z-index:3000;
}

.ui-dialog .ui-dialog-title {
  display:inline;
  text-align: center;
  width: 100%;
  z-index:3000;
}
</style>

<script>
$(function(){
	$('#dialog').dialog(
	{
		autoOpen: false,
		title: "Members",
		dialogClass: 'addMember',
	});
	$('#memBtn').click( function()
	{
		$('#dialog').dialog('open');
		$('.addMember').css({"color":"black","z-index":3000,"top":$('#memBtn').offset().top+20, "left" : $('#memBtn').offset().left,});
	});
});


$(document).ready(function(){
	$("#addText").hide();

    $("#descripstion").click(function(){
		$("#descripstion").hide();
		$("#addText").show();
	});
	 $("#cancel").click(function(){
		$("#addText").hide();
		$("#descripstion").show();
	});

	$('[data-toggle="popover"]').popover(); 
	
});

</script>
</head>

<body>
  
<button id='button_open_dialogg' data-toggle="modal" data-target="#detailThread">멤버</button>
 
<div id="dialog" style="z-index:2000;">
    <hr><input type="hidden" name="search" id="search" placeholder="Search members">
	<li class="list-group-item" id="member'.$i.'">세희 <input type="hidden" name="members[]" value="'.$name[nickname].'" />
	<input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="modalAddMember();" value="+" /></li>
	<li class="list-group-item" id="member'.$i.'">주현 <input type="hidden" name="members[]" value="'.$name[nickname].'" />
	<input type="button" class="pull-right" style="width:25px; height:25px; font-size:10px; border-radius:5px; background-color:white; border:1px solid #888888;" onclick="modalAddMember();" value="+" /></li>

</div>

<div class="modal" id="detailThread" style="z-index:2000">
	<div class="modal-dialog">
		<div class="modal-content" style="padding: 7px 7px 7px 7px;">
<div class="modal-body">
	<!--x 버튼-->
	<div class="form-group">
		<button type="button" style = "vertical-align:middle;" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon glyphicon-remove"></span></button>
	</div>
	<!--File title-->
	<div class="form-group">
		<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;
		<input type="text" class="form-control, bg" id="stepName" value="파일 제목" style="border: 0px; font-size:15pt; font-weight:bold;"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;in list <u>단계 이름</u>
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class ="glyphicon glyphicon-plus"></span>
		<a href="#" id ="memBtn" style ="text-align:center">멤버</a>
	</div>
	<br>

	<!--description--> 	 
	<div class="form-group">
		<p><button type="button" id = "descripstion" class="btn">&nbsp;&nbsp;&nbsp;
		<span class="glyphicon glyphicon-align-left" style = "color:gray"></span>&nbsp;<u><font color="gray" >추가 설명</font></u></button></p>
		<div id = "addText">
			<textarea id="addtt"class="form-control" placeholder="설명을 입력해주세요" style = "width:80%"></textarea>
			<button type="submit" id="submitBtn" class ="btn" style = "float:left;margin-top:5px; border-radius:5px; color:#fff; background-color:#D84747; width:50px">저장</button> &nbsp;
			<button type="button" id= "cancel" style = " vertical-align:middle; float:left; margin-top:11px; padding-left:12px" class="close" aria-hidden="true">✖</button>
		</div>
	</div><br>

	<div class="row">
		<div class = "col-lg-10">
			<!--comment--> 	 
			<div class="form-group">
				<label for="comment"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;댓글</label>
				<textarea class="form-control" placeholder="댓글을 입력해주세요"></textarea>
			</div>
			<!--body_history-->
			<div class="form-group">
				<label for="history"><span class="glyphicon glyphicon-th-list"></span>&nbsp;&nbsp;히스토리</label>
			</div>
		</div>

		<!--functions-->	
		<div class="col-lg-2">
			<h4><b>기능</b></h4>
			<div class="form-group">
				<button onclick="location.href='invite.php'" id="share" type="button" class="btn btn-default" data-dismiss="modal">공유</button>
			</div>
			<div class="form-group">
				<button onclick="location.href='invite.php'" type="button" class="btn btn-default" data-dismiss="modal">별점</button>
			</div>
			<div class="form-group">
				<button onclick="location.href='invite.php'" type="button" class="btn btn-default" data-dismiss="modal">투표</button>
			</div>
			<div class="form-group">
				<button onclick="location.href='invite.php'" type="button" class="btn btn-default" data-dismiss="modal">삭제</button>
			</div> 
		</div>
	</div>
</div></div></div></div>

</body>
</html>
