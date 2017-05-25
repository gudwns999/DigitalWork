<style>
.navbar-default {
    background-color: #f4511e;
    border-color: #f4511e;

	}
</style>


<nav class="navbar-default">


  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"><span style="color:white">디지털공방</span></a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="opendesign.php"><span style="color:white">오픈디자인?</span></a></li>
	  <li><a href="digital.php"><span style="color:white">디자인공방</span></a></li>	  
    </ul>


 	<?
		session_start();
		if($_SESSION["id"])
		{
	?>

  	    <ul class="nav navbar-nav navbar-right">
        <li><a><span style="color:white"> <?= $_SESSION["nick"] ?>님 환영합니다. <span class="glyphicon glyphicon-log-out" style="cursor:pointer;color:white" onclick="location.href='logout.php'" >로그아웃</span></span></a></li>
      </ul>

	<?} else {?>

		 <ul class="nav navbar-nav navbar-right">
      <li><a data-toggle="modal" data-target="#myModal"><span style="color:white" class="glyphicon glyphicon-log-in" data-toggle="modal" data-target="#myModal"></span> <span style="color:white;cursor:pointer;"> 로그인</span></a></li>
	  <li><a href="register.php"><span class="glyphicon glyphicon-user" style="color:white"></span><span style="color:white"> 회원가입</span></a></li>
    </ul>
	<?}?>

	<!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
	  <form method="post" onsubmit="return login();">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">로그인</h4>
        </div>
        <div class="modal-body">
         <div class="form-group">
             <label for="email">  아이디</label>
           <input type="text" class="form-control" name="loginid" id="email" placeholder="가입하신 이메일을 입력하세요.">
          </div>
          <div class="form-group">
            <label for="pwd">비밀번호</label>
            <input type="password" class="form-control" name="loginpwd" id="pwd" placeholder="비밀번호를 입력하세요.">
          </div>
        <center><button type="submit" class="btn btn-default">로그인</button></center>
      
        </div>
		</form>  
        <div class="modal-footer">
			<label>회원이 아니시라면 지금 가입해 보세요!&nbsp;&nbsp;&nbsp;<button onclick="location.href='register.php'" type="button" class="btn btn-default" data-dismiss="modal">회원가입</button></label><br>
        </div>
      </div>
    </div>
  </div>
  </div>
</nav>


