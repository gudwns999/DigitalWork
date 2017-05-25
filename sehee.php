<style>

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
}

.ui-dialog .ui-dialog-title {
  display:inline;
  text-align: center;
  width: 100%;
}
</style>
<script>

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

		
});
</script>
<!--body-->
<div class="modal-body">
	<!--x 버튼-->
	<div class="form-group">
		<button type="button" style = "vertical-align:middle;" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon glyphicon-remove"></span></button>
	</div>
	<!--File title-->
	<div class="form-group">
		<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;
		<input type="text" class="form-control, bg" value="파일 제목" style="border: 0px; font-size:15pt; font-weight:bold;"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;in list <u>단계 이름</u>
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class ="glyphicon glyphicon-plus"></span>
		<a href="#" id ="memBtn" style ="text-align:center" data-toggle="popover" title="Members" data-content="Some content inside the popover">멤버</a>
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
</div>
  