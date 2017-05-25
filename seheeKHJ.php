<style>
	.star_rating {font-size:0; letter-spacing:-4px;}
	.star_rating a {
		font-size:22px;
		letter-spacing:0;
		display:inline-block;
		margin-left:5px;
		color:#ccc;
		text-decoration:none;
	}
	.star_rating a:first-child {margin-left:0;}
	.star_rating a.on {color:#777;}

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
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="http://capstone.hae.so/v2/css/index.css">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$( ".star_rating a" ).click(function() {
			$(this).parent().children("a").removeClass("on");
			$(this).addClass("on").prevAll("a").addClass("on");
			return false;
		});

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

	function div_show() {
		document.getElementById('abc').style.display = "block";
	}

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
		<a href="#" style ="text-align:center" data-toggle="popover" title="Members" data-content="Some content inside the popover">멤버</a>

	</div><br>

	<!--description-->
	<div class="form-group">
		<p><button type="button" id = "descripstion" class="btn">&nbsp;&nbsp;&nbsp;
				<span class="glyphicon glyphicon-align-left" style = "color:gray"></span>&nbsp;<u><font color="gray" >추가 설명</font></u></button></p>
		<div id = "addText">
			<textarea id="addtt"class="form-control" placeholder="설명을 입력해주세요" style = "width:80%"></textarea>
			<button type="submit" id="submitBtn" class ="btn" style = "float:left;margin-top:5px; border-radius:5px; color:#fff; background-color:#D84747; width:50px">저장</button> &nbsp;
			<button type="button" id= "cancel" style = " vertical-align:middle; float:left; margin-top:11px; padding-left:12px" class="close" aria-hidden="true">✖</button>
		</div>
	</div>
	<br>
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
<p class="star_rating">
	<a href="#" class="on">★</a>
	<a href="#" class="on">★</a>
	<a href="#" class="on">★</a>
	<a href="#">★</a>
	<a href="#">★</a>
</p>