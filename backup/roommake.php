<!DOCTYPE html>
<html lang="ko">
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
      background: #000;
      color: #fff;
   }
  .btn-default:hover {
      background: #fff;
      color: #000;
   }
  </style>
</head>

<body>
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">디지털공방</a>
		</div>
		<ul class="nav navbar-nav">
		  <li><a href="#">생성</a></li>
		  <li class="active"><a href="#">제작</a></li>
		  <li><a href="#">배포</a></li>
		  <!-- 검색 아이콘 -->
		  <!--<span class="glyphicon glyphicon-search" align="right"></span>-->
		</ul>
		
		<ul class="nav navbar-nav navbar-right">
		  <li><a href="#"><span class="glyphicon glyphicon-log-in" data-toggle="modal" data-target="#myModal">로그인</span></a></li>
		  <li><a href="#"><span class="glyphicon glyphicon-search" data-toggle="modal" data-target="#searchModal">검색</span></a></li>
		</ul>
		
		<!-- 로그인 Modal -->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
		
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
				  <p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
		</div>
		
		<!-- 검색 Modal -->
		<div class="modal fade" id="searchModal" role="dialog">
			<div class="modal-dialog">
		
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Modal Header</h4>
				</div>
				<div class="modal-body">
				  <p>Some text in the modal.</p>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
		</div>
		
	  </div>
	</nav>
	  
	<div class="container">
		<div class="page-header">
			<h1>프로젝트 제작</h1>      
		</div>
		
	  <p>현재 참여하고 있는 프로젝트의 제작 정보입니다.</p>
	  <p>클릭을 하여 상세 내용을 확인하실 수 있습니다.</p>
	  
		<div class=text-right>
			<button type="button" class="btn btn-default">업로드</button>
		</div>
	</div>

	<!-- 진행 게시판 생성 -->
	<div class=text-center>
		<table class="table table-hover">
			<h1> 진행 상황 </h1>
				<thead>
					<tr>
						<td align="center" ><strong>번호</strong></td>
						<td><strong>작업내용</strong></td>
						<td align="center" ><strong>작업자</strong></td>
						<td align="center" ><strong>작업일</strong></td>
					</tr>
				</thead>
				<tr>
					<td class="no">1</td>
					<td class="title">테스트 1</td>
					<td class="author">작성자 1</td>
					<td class="date">16.03.15</td>
				</tr>
		</table>
		
		<ul class="pagination">
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
		</ul>
		
	</div>
</body>
</html>
